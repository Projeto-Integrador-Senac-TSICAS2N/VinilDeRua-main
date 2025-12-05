<?php
session_start();
require_once __DIR__ . "/conexao.php";

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) exit("ID inválido");

// Buscar o produto real do banco
$stmt = $pdo->prepare("SELECT id, nome, preco, img_link FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) exit("Produto não encontrado");

// Criar a sessão do carrinho
if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (!isset($_SESSION['carrinho'][$id])) {
    $_SESSION['carrinho'][$id] = [
        'id' => $produto['id'],
        'nome' => $produto['nome'],
        'preco' => $produto['preco'],
        'img_link' => $produto['img_link'],
        'qtd' => 1
    ];
} else {
    $_SESSION['carrinho'][$id]['qtd']++;
}


// Se veio do botão COMPRAR AGORA → redireciona para carrinho
if (isset($_GET['redirect']) && $_GET['redirect'] === 'carrinho') {
    header("Location: ../pages/carrinho.php");
    exit;
}


// Se foi só "adicionar" → volta para página anterior
header("Location: ../pages/carrinho.php");
exit;
?>
