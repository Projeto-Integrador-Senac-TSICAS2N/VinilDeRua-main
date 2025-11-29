<?php
session_start();
require_once __DIR__ . '/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome       = trim($_POST['nome']);
    $email = strtolower(trim($_POST['email']));
    $email = preg_replace('/\s+/', '', $email);
    $senha      = $_POST['senha'];
    $confirma   = $_POST['confirma_senha']; 
    $telefone   = trim($_POST['telefone']);
    $cep        = trim($_POST['cep']);
    $endereco   = trim($_POST['endereco']);
    $complemento = trim($_POST['complemento']);
    $cidade     = trim($_POST['cidade']);
    $estado     = trim($_POST['estado']);

    // Verificações
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['erro'] = "E-mail inválido.";
        header("Location: ../pages/cadastrarUser.php");
        exit();
    }

    if ($senha !== $confirma) {
        $_SESSION['erro'] = "As senhas não coincidem.";
        header("Location: ../pages/cadastrarUser.php");
        exit();
    }

    if (strlen($senha) < 6) {
        $_SESSION['erro'] = "A senha deve ter pelo menos 6 caracteres.";
        header("Location: ../pages/perfilUsuario.php");
        exit();
    }


    // Hash da senha
    $hash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        // Usando transação pois há múltiplas tabelas
        $pdo->beginTransaction();

        // Inserir usuário
        $sqlUser = "INSERT INTO usuarios (nome, email, senha, data_criacao, nivel_permissao) 
            VALUES (?, ?, ?, NOW(), 0)";
        $stmt = $pdo->prepare($sqlUser);
        $stmt->execute([$nome, $email, $hash]);


        $usuarioId = $pdo->lastInsertId();

        // Inserir telefone
        $sqlTel = "INSERT INTO telefones (usuario_id, numero_usuario, tipo) VALUES (?, ?, ?)";
        $stmtTel = $pdo->prepare($sqlTel);
        $stmtTel->execute([$usuarioId, $telefone, 'principal']);

        // Inserir endereço
        $sqlEnd = "INSERT INTO enderecos (usuario_id, CEP, Logradouro, complemento, Cidade, Estado) VALUES (?, ?, ?, ?, ?, ?)";
        $stmtEnd = $pdo->prepare($sqlEnd);
        $stmtEnd->execute([$usuarioId, $cep, $endereco, $complemento, $cidade, $estado]);

        $pdo->commit();

        $_SESSION['sucesso'] = "Conta criada com sucesso! Faça login.";
        header("Location: /VinilDeRua-main/vinil de rua/index.php");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Erro ao cadastrar: " . $e->getMessage());
    }
}
