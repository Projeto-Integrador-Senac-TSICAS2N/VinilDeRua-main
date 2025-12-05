<?php
session_start();

$id = intval($_GET['id'] ?? 0);
$op = $_GET['op'] ?? '';

if (!isset($_SESSION['carrinho'][$id])) {
    header("Location: ../pages/carrinho.php");
    exit;
}

switch ($op) {

    case 'qtd':
        $novaQtd = intval($_GET['v'] ?? 1);
        if ($novaQtd <= 0) {
            unset($_SESSION['carrinho'][$id]);
        } else {
            $_SESSION['carrinho'][$id]['qtd'] = $novaQtd;
        }
        break;

    case 'remover':
        unset($_SESSION['carrinho'][$id]);
        break;
}

header("Location: ../pages/carrinho.php");
exit;
?>