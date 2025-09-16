<?php
require_once __DIR__ . '/../inc/auth.php';
require_admin();
require_once __DIR__ . '/../../inc/db.php';
$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM promotions WHERE id = :id");
    $stmt->execute([':id' => $id]);
}
header('Location: index.php');
exit;
