<?php
require_once __DIR__ . '/inc/auth.php';
require_admin();
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<title>Admin — Dashboard</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Admin — Mon Épicerie</a>
    <div>
      <a class="btn btn-outline-secondary" href="logout.php">Se déconnecter</a>
    </div>
  </div>
</nav>

<main class="container py-4">
  <div class="row gap-3">
    <div class="col-md-4">
      <div class="card shadow-sm p-3">
        <h5>Abonnés</h5>
        <p><a href="subscribers.php" class="btn btn-sm btn-primary">Voir la liste</a></p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm p-3">
        <h5>Promotions</h5>
        <p><a href="promotions/index.php" class="btn btn-sm btn-primary">Gérer promotions</a></p>
      </div>
    </div>
  </div>
</main>
</body>
</html>
