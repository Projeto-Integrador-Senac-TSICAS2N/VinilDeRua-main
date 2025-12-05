<?php
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_nivel'] < 1) {
    echo json_encode(["erro" => "Acesso negado"]);
    exit;
}

require_once __DIR__ . '/conexao.php';

$usuarios   = $con->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc()['total'];
$produtos   = $con->query("SELECT COUNT(*) AS total FROM produtos")->fetch_assoc()['total'];
$pedidos    = 0; // implementar depois
$lowStock   = $con->query("SELECT COUNT(*) AS total FROM produtos WHERE estoque <= 2")->fetch_assoc()['total'];

echo json_encode([
    "usuarios" => $usuarios,
    "produtos" => $produtos,
    "pedidos" => $pedidos,
    "estoqueBaixo" => $lowStock
]);
?>