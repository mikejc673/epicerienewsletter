<?php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../../inc/db.php';
$stmt = $pdo->query("SELECT * FROM promotions ORDER BY active DESC, created_at DESC");
$items = $stmt->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head><meta charset="utf-8"><title>Admin — Promotions</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
<div class="container py-4">
  <h1>Promotions</h1>
  <a href="../dashboard.php" class="btn btn-sm btn-link">← Dashboard</a>
  <a href="create.php" class="btn btn-sm btn-primary ms-2">Nouvelle promotion</a>
  <div class="table-responsive mt-3">
    <table class="table table-hover">
      <thead><tr><th>#</th><th>Titre</th><th>Prix</th><th>Période</th><th>Actif</th><th>Actions</th></tr></thead>
      <tbody>
        <?php foreach($items as $it): ?>
        <tr>
          <td><?php echo (int)$it['id']; ?></td>
          <td><?php echo htmlspecialchars($it['title']); ?></td>
          <td><?php echo number_format($it['price'],2,',',' '); ?>€ <?php if($it['old_price']) echo '<span class="text-decoration-line-through text-muted ms-2">'.number_format($it['old_price'],2,',',' ').'€</span>'; ?></td>
          <td><?php echo htmlspecialchars($it['start_date']) . ' → ' . htmlspecialchars($it['end_date']); ?></td>
          <td><?php echo $it['active'] ? 'Oui' : 'Non'; ?></td>
          <td>
            <a class="btn btn-sm btn-outline-secondary" href="edit.php?id=<?php echo $it['id']; ?>">Éditer</a>
            <a class="btn btn-sm btn-danger" href="delete.php?id=<?php echo $it['id']; ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
