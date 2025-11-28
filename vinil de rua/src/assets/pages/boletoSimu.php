<?php
session_start();

// Se o usuário não estiver logado, manda pro login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: perfilUsuario.php");
    exit;
}

// Recupera o carrinho e calcula o total
$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;

foreach ($carrinho as $item) {
    $total += $item['preco'] * $item['qtd'];
}

// Dados fake
$linhaDigitavel = "34191.79001 01043.510047 91020.150008 9 756900000" . str_replace(['.', ','], "", number_format($total, 2));
$codigoBarras = "3419" . rand(100000000000000000, 999999999999999999);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Boleto - Vinil de Rua</title>
    <style>
        body {
            background: #e6e6e6;
            display: flex;
            justify-content: center;
            padding-top: 40px;
            font-family: Arial, sans-serif;
        }

        .boletoContainer {
            width: 700px;
            background: #fff;
            padding: 25px;
            border: 2px solid #000;
            border-radius: 10px;
        }

        .titulo {
            text-align: center;
            font-size: 28px;
            font-family: 'Caesar Dressing', cursive;
        }

        .linhaDigitavel {
            font-size: 20px;
            margin-top: 20px;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
            font-family: "Sahitya", serif;
        }

        .codigoBarras {
            font-size: 26px;
            margin: 25px 0;
            letter-spacing: 6px;
            font-family: monospace;
            text-align: center;
        }

        .box {
            margin-top: 20px;
            font-size: 18px;
        }

        .btnArea {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 35px;
        }

        button {
            padding: 12px 25px;
            cursor: pointer;
            border: 2px solid #000;
            background: #000;
            color: #fff;
            transition: .2s;
            font-family: "Caesar Dressing";
        }

        button:hover {
            transform: scale(1.05);
            background: #fff;
            color: #000;
        }
    </style>
</head>

<body>

<div class="boletoContainer">
    <p class="titulo">Boleto Bancário</p>

    <p class="linhaDigitavel"><?php echo $linhaDigitavel ?></p>

    <p style="margin-top:15px;">Beneficiário: <strong>Vinil de Rua LTDA</strong></p>
    <p>Pagador: <strong><?= htmlspecialchars($_SESSION['usuario_nome']) ?></strong></p>
    <p>Vencimento: <strong><?= date("d/m/Y", strtotime("+3 days")) ?></strong></p>

    <div class="codigoBarras">
        ||| |||| || ||| ||| ||||| || ||| ||| ||||| || | ||| ||
    </div>

    <div class="box">
        <strong>Valor:</strong> R$<?= number_format($total, 2, ',', '.') ?>
    </div>

    <div class="btnArea">
        <button onclick="window.print()">Baixar Boleto</button>
        <button onclick="window.location.href='resumoCompra.php'">Já paguei</button>
    </div>
</div>

</body>
</html>
