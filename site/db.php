<?php
declare(strict_types=1);

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
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage());
}