<?php
session_start();
require_once __DIR__ . "/../scripts/protecaoLogin.php";
require_once __DIR__ . "/../scripts/conexao.php";

// ======================= CARRINHO ======================= //
$carrinhoSession = $_SESSION['carrinho'] ?? [];
$carrinho = [];
$totalProdutos = 0;

if (!empty($carrinhoSession)) {
    foreach ($carrinhoSession as $item) {
        $stmt = $pdo->prepare("SELECT id, nome, preco, categoria, autor, genero, estoque, data_introducao, img_link 
                               FROM produtos WHERE id = ?");
        $stmt->execute([$item['id']]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($produto) {
            $produto['qtd'] = $item['qtd'];
            $produto['subtotal'] = $produto['preco'] * $item['qtd'];
            $totalProdutos += $produto['subtotal'];
            $carrinho[] = $produto;
        }
    }
}

// ======================= USUÁRIO ======================= //
$usuario = [
    "email" => $_SESSION['usuario_email'] ?? "Não informado"
];

// ======================= ENDEREÇO ======================= //
$endereco = $_SESSION['endereco_usuario'] ?? [
    "nome" => "Não informado",
    "rua" => "Não informado",
    "cep" => "-",
    "complemento" => "-",
    "cidade" => "-",
    "estado" => "-",
    "telefone" => "-"
];

// ======================= ENTREGA ======================= //
$entrega = $_SESSION['metodo_entrega'] ?? [
    "tipo" => "Entrega Normal",
    "info" => "Prazo 3-7 dias úteis",
    "preco" => 10.00
];

$totalFinal = $totalProdutos + $entrega["preco"];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo da compra</title>

    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../styles/resumoCompra.css">
    <link rel="shortcut icon" type="imagex/png" href="../images/logoVinilDeRua.svg">
</head>

<body>

<div id="preloader">
    <img src="https://i.ibb.co/qYwvJYpw/loading.gif">
</div>

<header>
    <div class="logoHeader">
        <a href="/VinilDeRua-main/vinil de rua/index.php"><img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png"></a>
        <p>VINIL <br>DE RUA</p>
    </div>

    <nav>
        <a href="../../catalogo.php">Cátalogo</a>
        <a href="../../ofertas.php">Ofertas</a>
        <a href="../../contato.php">Contato</a>
    </nav>

    <div class="icons">
        <a href="../pages/favorito.php"><img src="https://i.ibb.co/ynVyBhq2/favorite.png"></a>
        <a href="../pages/carrinho.php"><img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png"></a>
        <a href="../pages/perfilUsuario.php"><img src="https://i.ibb.co/4RGqW28z/account-circle.png"></a>
    </div>
</header>


<section class="fundoPrincipal">

    <section class="resumoCompra">

        <div class="txtResumo">
            <h1>Resumo da compra:</h1>
        </div>

        <!-- ===================== INFORMAÇÕES ===================== -->
        <section class="cardsInfos">

            <!-- CONTATO -->
            <div class="cardResumo">
                <div class="tituloEditar">
                    <h1>Contato:</h1>
                    <a href="">Editar</a>
                </div>
                <p><?= $usuario["email"] ?></p>
            </div>

            <!-- ENDEREÇO -->
            <div class="cardResumo">
                <div class="tituloEditar">
                    <h1>Endereço:</h1>
                    <a href="">Editar</a>
                </div>
                <p><?= $endereco['nome'] ?></p>
                <p><?= $endereco['rua'] ?></p>
                <p><?= $endereco['cep'] ?></p>
                <p><?= $endereco['complemento'] ?></p>
                <p><?= $endereco['cidade'] ?>, <?= $endereco['estado'] ?> - BR</p>
                <p><?= $endereco['telefone'] ?></p>
            </div>

            <!-- ENTREGA -->
            <div class="cardResumo">
                <div class="tituloEditar">
                    <h1>Opções de entrega:</h1>
                    <a href="">Editar</a>
                </div>
                <p><?= $entrega['tipo'] ?></p>
                <p><?= $entrega['info'] ?></p>
                <p>R$<?= number_format($entrega['preco'], 2, ",", ".") ?></p>
            </div>

        </section>


        <!-- ===================== PEDIDOS ===================== -->
        <div class="pedidoFinal">

            <div class="cardResumo">
                <div class="tituloEditar">
                    <h1>Seu pedido</h1>
                    <a href="../pages/carrinho.php">Editar</a>
                </div>

                <div class="produtosFinais">

                    <?php foreach ($carrinho as $item): ?>
                        <div class="produtoItem">
                            <img src="<?= $item['img_link'] ?>">
                            <div class="infosFinais">
                                <h1><?= $item['nome'] ?></h1>
                                <p><strong>Autor:</strong> <?= $item['autor'] ?></p>
                                <p><strong>Gênero:</strong> <?= $item['genero'] ?></p>
                                <p><strong>Categoria:</strong> <?= $item['categoria'] ?></p>
                                <p><strong>Preço unitário:</strong> R$<?= number_format($item['preco'], 2, ",", ".") ?></p>
                                <p><strong>Quantidade:</strong> <?= $item['qtd'] ?></p>
                                <p><strong>Subtotal:</strong> R$<?= number_format($item['subtotal'], 2, ",", ".") ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

                <div class="infosPessoaisCompra">
                    <p>Produtos: <?= count($carrinho) ?> — R$<?= number_format($totalProdutos, 2, ",", ".") ?></p>
                    <p>Entrega: <?= $entrega['tipo'] ?> — R$<?= number_format($entrega['preco'], 2, ",", ".") ?></p>
                    <p><strong>Total: R$<?= number_format($totalFinal, 2, ",", ".") ?></strong></p>
                </div>
            </div>
        </div>

       

    </section>

    <footer id="contato">
        <div class="footerLogo">
            <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png">
            <h1>VINIL <br>DE RUA</h1>
        </div>

        <div class="avisosFooter">
            <p>Duvidas? (11) 4002-8922 (SP)</p>
            <p>Seg a Sex, 9h às 21h — Sáb 10h às 18h</p>
        </div>

        <div class="termos">
            <a href="">Termos e Condições</a>
        </div>
    </footer>

</section>

<script src="../scripts/loading.js"></script>
<script src="../scripts/profileScript.js"></script>
<script src="../scripts/navbar.js"></script>

</body>
</html>
