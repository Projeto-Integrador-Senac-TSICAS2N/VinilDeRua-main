<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    // Guarda a página que o usuário tentou acessar
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];

    // Redireciona para login
    header("Location: /VinilDeRua-main/vinil de rua/src/assets/pages/perfilUsuario.php");
    exit;   
}
?>  