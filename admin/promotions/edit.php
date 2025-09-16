<?php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../../inc/db.php';
$id = (int)($_GET['id'] ?? 0);
if (!$id) { header('Location: index.php'); exit; }
$stmt = $pdo->prepare("SELECT * FROM promotions WHERE id = :id");
$stmt->execute([':id' => $id]);
$item = $stmt->fetch();
if (!$item) { header('Location: index.php'); exit; }
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = (float)($_POST['price'] ?? 0);
    $old_price = ($_POST['old_price'] === '') ? null : (float)$_POST['old_price'];
    $start = $_POST['start_date'] ?: null;
    $end = $_POST['end_date'] ?: null;
    $active = isset($_POST['active']) ? 1 : 0;
    $imagePath = $item['product_image'];
    if (!empty($_FILES['product_image']['name'])) {
        $u = $_FILES['product_image'];
        if ($u['error'] === UPLOAD_ERR_OK && preg_match('/image\//', $u['type'])) {
            $ext = pathinfo($u['name'], PATHINFO_EXTENSION);
            $fileName = 'uploads/prom_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            @mkdir(__DIR__ . '/../../uploads', 0755, true);
            if (move_uploaded_file($u['tmp_name'], __DIR__ . '/../../' . $fileName)) {
                $imagePath = $fileName;
            } else {
                $errors[] = "Impossible d'uploader l'image.";
            }
        } else {
            $errors[] = "Fichier image invalide.";
        }
    }
    if (!$title) $errors[] = "Le titre est requis.";
    if ($price <= 0) $errors[] = "Prix invalide.";
    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE promotions SET title=:title, description=:desc, product_image=:img, price=:price, old_price=:old_price, start_date=:start, end_date=:end, active=:active WHERE id=:id");
        $stmt->execute([
            ':title' => $title,
            ':desc' => $description,
            ':img' => $imagePath,
            ':price' => $price,
            ':old_price' => $old_price,
            ':start' => $start,
            ':end' => $end,
            ':active' => $active,
            ':id' => $id
        ]);
        header('Location: index.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="fr">
<head><meta charset="utf-8"><title>Éditer promotion</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
<div class="container py-4">
  <h1>Éditer promotion</h1>
  <a href="index.php" class="btn btn-sm btn-link">← Retour</a>
  <?php if($errors): foreach($errors as $e){ echo "<div class='alert alert-danger'>".htmlspecialchars($e)."</div>"; } endif; ?>
  <form method="post" enctype="multipart/form-data" class="mt-3">
    <div class="mb-2">
      <label class="form-label">Titre<input class="form-control" name="title" required value="<?php echo htmlspecialchars($item['title']); ?>"></label>
    </div>
    <div class="mb-2">
      <label class="form-label">Description<textarea class="form-control" name="description"><?php echo htmlspecialchars($item['description']); ?></textarea></label>
    </div>
    <?php if($item['product_image']): ?>
      <p>Image actuelle:<br><img src="/<?php echo htmlspecialchars($item['product_image']); ?>" style="max-width:200px"></p>
    <?php endif; ?>
    <div class="mb-2"><label class="form-label">Remplacer l'image <input class="form-control" type="file" name="product_image" accept="image/*"></label></div>
    <div class="row">
      <div class="col"><label class="form-label">Prix<input class="form-control" name="price" required value="<?php echo htmlspecialchars($item['price']); ?>"></label></div>
      <div class="col"><label class="form-label">Ancien prix<input class="form-control" name="old_price" value="<?php echo htmlspecialchars($item['old_price']); ?>"></label></div>
    </div>
    <div class="row mt-2">
      <div class="col"><label class="form-label">Début<input class="form-control" type="date" name="start_date" value="<?php echo htmlspecialchars($item['start_date']); ?>"></label></div>
      <div class="col"><label class="form-label">Fin<input class="form-control" type="date" name="end_date" value="<?php echo htmlspecialchars($item['end_date']); ?>"></label></div>
    </div>
    <div class="form-check mt-2">
      <input class="form-check-input" type="checkbox" name="active" <?php echo $item['active'] ? 'checked' : ''; ?>>
      <label class="form-check-label">Actif</label>
    </div>
    <button class="btn btn-primary mt-3">Enregistrer</button>
  </form>
</div>
</body>
</html>
