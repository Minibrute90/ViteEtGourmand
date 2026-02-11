<?php

$host = 'arsedifvitegourm.mysql.db';
$db   = 'arsedifvitegourm';
$user = 'arsedifvitegourm';
$pass = 'Vg2026Test123';

try {
    $connexionBdd = new PDO(
        "mysql:host=$host;port=3306;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]
    );
} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    $connexionBdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $menuId = (int)($_GET['id'] ?? 0);
    $photoIndex = (int)($_GET['p'] ?? 1);

    if ($menuId <= 0 || $photoIndex < 1 || $photoIndex > 3) {
        http_response_code(400);
        exit("Paramètres invalides (id/p)");
    }

    $photoCol = "photo" . $photoIndex;
    $mimeCol  = "mime_photo" . $photoIndex;

    // 🔎 vérifie que la table existe
    $tables = $connexionBdd->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array('menus', $tables, true)) {
        http_response_code(500);
        exit("Table 'menus' introuvable dans la base viteetgourmand");
    }

    // 🔎 vérifie que la ligne existe + que le blob n'est pas vide
    $stmt = $connexionBdd->prepare("SELECT LENGTH($photoCol) AS len, $mimeCol AS mime FROM menus WHERE menu_id=?");
    $stmt->execute([$menuId]);
    $check = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$check) {
        http_response_code(404);
        exit("menu_id=$menuId introuvable");
    }
    if (empty($check['len'])) {
        http_response_code(404);
        exit("$photoCol vide pour menu_id=$menuId");
    }

    // ✅ maintenant on renvoie l'image
    $stmt2 = $connexionBdd->prepare("SELECT $photoCol AS img, $mimeCol AS mime FROM menus WHERE menu_id=?");
    $stmt2->execute([$menuId]);
    $row = $stmt2->fetch(PDO::FETCH_ASSOC);

    $mime = $row['mime'] ?: 'image/jpeg';

    header("Content-Type: $mime");
    header("Content-Length: " . strlen($row['img']));
    echo $row['img'];

} catch (Throwable $e) {
    http_response_code(500);
    echo "ERREUR: " . $e->getMessage();
}