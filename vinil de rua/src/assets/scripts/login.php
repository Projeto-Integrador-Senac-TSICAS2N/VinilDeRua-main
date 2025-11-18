<?php
session_start();
require_once __DIR__ . '/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = strtolower(trim($_POST['email']));
    $email = preg_replace('/\s+/', '', $email); // remove espaços invisíveis

    $senha = $_POST['senha'];

    // Buscar usuário pelo email
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se o usuário existe
    if (!$usuario) {
        $_SESSION['erro'] = "E-mail não encontrado.";
        header("Location: ../pages/perfilUsuario.php");
        exit();
    }

    // Validar senha
    if (!password_verify($senha, $usuario['senha'])) {
        $_SESSION['erro'] = "Senha incorreta.";
        header("Location: ../pages/perfilUsuario.php");
        exit();
    }

    // Login autorizado -> criar sessão
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['usuario_nivel'] = $usuario['nivel_permissao'];

    $_SESSION['sucesso'] = "Login realizado com sucesso.";

    // Redirecionar para a página protegida
    header("Location: /VinilDeRua-main/vinil%20de%20rua/index.php");
    exit();
}
?>