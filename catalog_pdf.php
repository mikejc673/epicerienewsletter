<?php
require __DIR__ . '/inc/db.php';
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    die("Dompdf non installé. Exécutez: composer require dompdf/dompdf");
}
require __DIR__ . '/vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$promos = $pdo->query("SELECT * FROM promotions WHERE active=1 ORDER BY created_at DESC")->fetchAll();

$html = '<!doctype html><html><head><meta charset="utf-8"><style>
body{font-family: DejaVu Sans, Arial, Helvetica, sans-serif;font-size:12px}
.card{border:1px solid #ccc;padding:8px;margin-bottom:10px;display:flex;gap:10px}
.card img{width:140px;height:90px;object-fit:cover}
.price{font-weight:700}
.header{display:flex;justify-content:space-between;align-items:center}
</style></head><body>';
$html .= '<div class="header"><h1>Catalogue — Mon Épicerie</h1><div>'.date('d/m/Y').'</div></div>';

foreach($promos as $p){
    $html .= '<div class="card">';
    if($p['product_image']){
      $imgPath = realpath(__DIR__ . '/' . $p['product_image']);
      if ($imgPath && file_exists($imgPath)) {
          $data = base64_encode(file_get_contents($imgPath));
          $mime = mime_content_type($imgPath);
          $html .= "<div><img src='data:$mime;base64,$data'></div>";
      }
    }
    $html .= '<div><h2>'.htmlspecialchars($p['title']).'</h2>';
    $html .= '<p>'.nl2br(htmlspecialchars($p['description'])).'</p>';
    $html .= '<p class="price">'.number_format($p['price'],2,',',' ').'€';
    if($p['old_price']) $html .= ' <span style="text-decoration:line-through;color:#777">'.number_format($p['old_price'],2,',',' ').'€</span>';
    $html .= '</p>';
    $html .= '</div></div>';
}

$html .= '</body></html>';

$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("catalogue_".date('Ymd').".pdf", ["Attachment" => true]);
exit;
