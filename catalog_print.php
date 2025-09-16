<?php
require __DIR__ . '/inc/db.php';
$promos = $pdo->query("SELECT * FROM promotions WHERE active=1 ORDER BY created_at DESC")->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Catalogue — Imprimable</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
  @page { margin: 15mm; }
  body{font-family:Arial,Helvetica,sans-serif;color:#111}
  header{display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem}
  .grid{display:grid;grid-template-columns:repeat(2,1fr);gap:1rem}
  .card{border:1px solid #ddd;padding:10px;border-radius:6px;display:flex;gap:10px}
  .card img{width:160px;height:100px;object-fit:cover}
  .price{font-weight:700}
  .old{ text-decoration:line-through;color:#999;margin-left:8px}
  @media print {
    .no-print{display:none}
    .grid{grid-template-columns:repeat(2,1fr)}
  }
</style>
</head>
<body>
  <header>
    <div>
      <h1>Catalogue — Mon Épicerie</h1>
      <p>Date : <?php echo date('d/m/Y'); ?></p>
    </div>
    <div class="no-print">
      <button onclick="window.print()">Imprimer / Enregistrer en PDF</button>
    </div>
  </header>

  <main>
    <div class="grid">
      <?php foreach($promos as $p): ?>
        <article class="card">
          <?php if($p['product_image']): ?>
            <img src="<?php echo htmlspecialchars($p['product_image']); ?>" alt="<?php echo htmlspecialchars($p['title']); ?>">
          <?php endif; ?>
          <div>
            <h2><?php echo htmlspecialchars($p['title']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($p['description'])); ?></p>
            <p class="price"><?php echo number_format($p['price'],2,',',' '); ?>€<?php if($p['old_price']) echo '<span class="old">'.number_format($p['old_price'],2,',',' ').'€</span>'; ?></p>
            <?php if($p['start_date'] || $p['end_date']): ?>
              <p>Valable : <?php echo htmlspecialchars($p['start_date']).' → '.htmlspecialchars($p['end_date']); ?></p>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </main>
</body>
</html>
