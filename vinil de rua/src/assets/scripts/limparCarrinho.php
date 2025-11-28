<?php
session_start();
unset($_SESSION['carrinho']); // remove o carrinho
echo "OK";
?>
