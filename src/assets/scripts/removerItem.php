<?php
session_start();

$id = $_GET['id'];
unset($_SESSION['carrinho'][$id]);

header("Location: ../assets/pages/carrinho.php");
exit;
?>