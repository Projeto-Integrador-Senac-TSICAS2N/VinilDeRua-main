<?php
require_once __DIR__ . "/../scripts/protecaoLogin.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: perfilUsuario.php");
    exit;
}

$nome = $_SESSION['usuario_nome'] ?? '';
$email = $_SESSION['usuario_email'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Identificação - Vinil de Rua</title>
    <link rel="stylesheet" href="../styles/styleCarrinho.css">
</head>

<body>

<section class="fundoPrincipal">
    
    <h1 style="font-family: var(--fontePrimaria); font-size: 36px;">Identificação</h1>

    <div class="identificacaoBox" style="background:#fff;padding:30px;border-radius:10px;border:2px solid #000;font-family:var(--fonteTerciaria);width:400px;">

        <p><strong>Nome:</strong> <?= htmlspecialchars($nome) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>

        <a href="pagamento.php">
            <button style="margin-top:20px;padding:10px 20px;cursor:pointer;border:2px solid #000;font-family:var(--fontePrimaria);font-size:22px;">
                Continuar
            </button>
        </a>
    </div>

</section>

</body>
</html>
