<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'arsedifvitegourm.mysql.db';
$db   = 'arsedifvitegourm';
$user = 'arsedifvitegourm';
$pass = 'Vg2026Test123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "✅ Connexion BDD OK";
} catch (PDOException $e) {
    echo "❌ " . $e->getMessage();
}