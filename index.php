<?php
require __DIR__ . '/inc/db.php';
$promos = $pdo->query("SELECT * FROM promotions WHERE active=1 ORDER BY created_at DESC")->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Mon Épicerie — Promotions</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Mon Épicerie</a>
    <div class="d-flex">
      <a class="btn btn-outline-primary" href="/admin/login.php">Admin</a>
    </div>
  </div>
</nav>

<main class="container py-4">
  <h1 class="mb-3">Promotions en cours</h1>
  <div class="row">
    <?php foreach($promos as $p): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <?php if($p['product_image']): ?>
            <img src="<?php echo htmlspecialchars($p['product_image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($p['title']); ?>" style="height:200px;object-fit:cover;">
          <?php endif; ?>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo htmlspecialchars($p['title']); ?></h5>
            <p class="card-text text-muted small"><?php echo nl2br(htmlspecialchars($p['description'])); ?></p>
            <div class="mt-auto">
              <p class="mb-1 fw-bold"><?php echo number_format($p['price'],2,',',' '); ?>€ <?php if($p['old_price']) echo '<span class="text-decoration-line-through text-muted ms-2">'.number_format($p['old_price'],2,',',' ').'€</span>'; ?></p>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <a class="btn btn-secondary mt-3" href="/catalog_print.php" target="_blank">Voir version imprimable</a>
</main>
</body>
</html>
