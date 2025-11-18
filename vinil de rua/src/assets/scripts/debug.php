<?php
require_once __DIR__ . '/conexao.php';

$sql = "SELECT email FROM usuarios";
$stmt = $pdo->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

print_r($result);
