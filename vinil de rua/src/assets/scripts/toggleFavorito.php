<?php
session_start();

require_once __DIR__ . "/conexao.php";
require_once __DIR__ . "/protecaoLogin.php"; // garante que só logado usa

// Usuário logado
$usuarioId = $_SESSION['usuario_id'] ?? null;

// Id do produto vindo da URL
$produtoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

// De onde vamos voltar depois da ação
$redirect = $_GET['redirect'] ?? 'back';

if (!$usuarioId || !$produtoId) {
    // Se algo vier errado, volta pra página anterior ou catálogo
    if (!empty($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ../pages/catalogo.php");
    }
    exit;
}

// Verifica se já existe favorito
$stmt = $pdo->prepare("
    SELECT id 
    FROM favoritos 
    WHERE usuario_id = :u AND produto_id = :p
");
$stmt->execute([
    ':u' => $usuarioId,
    ':p' => $produtoId
]);

if ($stmt->fetch()) {
    // Já é favorito -> REMOVE (toggle)
    $stmt = $pdo->prepare("
        DELETE FROM favoritos 
        WHERE usuario_id = :u AND produto_id = :p
    ");
    $stmt->execute([
        ':u' => $usuarioId,
        ':p' => $produtoId
    ]);
} else {
    // Não é favorito -> ADICIONA
    $stmt = $pdo->prepare("
        INSERT INTO favoritos (usuario_id, produto_id, data_favorito)
        VALUES (:u, :p, NOW())
    ");
    $stmt->execute([
        ':u' => $usuarioId,
        ':p' => $produtoId
    ]);
}

// Redireciona
switch ($redirect) {
    case 'favoritos':
        header("Location: ../pages/favorito.php");
        break;

    case 'carrinho':
        header("Location: ../pages/carrinho.php");
        break;

    default:
        if (!empty($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            header("Location: ../pages/catalogo.php");
        }
}

exit;
?>