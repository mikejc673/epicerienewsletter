<?php
// inc/db.php - Configure your DB credentials
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'epicerie');
define('DB_USER', 'root');
define('DB_PASS', 'votre_mot_de_passe');
define('DB_CHARSET', 'utf8mb4');

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
        DB_USER,
        DB_PASS,
        $options
    );
} catch (Exception $e) {
    die("Erreur de connexion à la base de données.");
}
