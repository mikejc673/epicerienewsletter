<?php
require_once __DIR__ . '/inc/auth.php';
require_admin();
require_once __DIR__ . '/../inc/db.php';

$page = max(1, (int)($_GET['page'] ?? 1));
$per = 40;
$offset = ($page - 1) * $per;

$total = $pdo->query("SELECT COUNT(*) FROM subscribers")->fetchColumn();
$stmt = $pdo->prepare("SELECT * FROM subscribers ORDER BY created_at DESC LIMIT :lim OFFSET :off");
$stmt->bindValue(':lim', $per, PDO::PARAM_INT);
$stmt->bindValue(':off', $offset, PDO::PARAM_INT);
$stmt->execute();
$subs = $stmt->fetchAll();
?>
<!doctype html>
<html lang="fr">
<head><meta charset="utf-8"><title>Admin — Abonnés</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
<div class="container py-4">
  <h1 class="mb-3">Abonnés (<?php echo $total; ?>)</h1>
  <a href="dashboard.php" class="btn btn-sm btn-link mb-3">← Retour</a>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead><tr><th>#</th><th>Nom</th><th>Email</th><th>Inscrit le</th></tr></thead>
      <tbody>
      <?php foreach($subs as $s): ?>
        <tr>
          <td><?php echo (int)$s['id']; ?></td>
          <td><?php echo htmlspecialchars($s['name']); ?></td>
          <td><?php echo htmlspecialchars($s['email']); ?></td>
          <td><?php echo htmlspecialchars($s['created_at']); ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php
    $pages = ceil($total / $per);
    for($i=1;$i<=$pages;$i++){
      if($i===$page){ echo "<strong>$i</strong> "; } else { echo "<a href='?page=$i'>$i</a> "; }
    }
  ?>
</div>
</body>
</html>
