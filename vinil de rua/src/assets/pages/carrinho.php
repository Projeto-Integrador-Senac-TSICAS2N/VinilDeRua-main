<?php
session_start();
require_once __DIR__ . "/../scripts/protecaoLogin.php";

$carrinho = $_SESSION['carrinho'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Meu carrinho - Vinil de Rua</title>

    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../styles/styleCarrinho.css">
    <link rel="icon" href="../images/logoVinilDeRua.svg">
</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
    </div>

    <header>
        <div class="logoHeader">
            <a href="../../../index.php">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="logo-Vinil-De-Rua">
            </a>
            <p>Vinil <br>de Rua</p>
        </div>
        <nav>
            <a href="../../index.php">Cátalogo</a>
            <a href="../../index.php">Ofertas</a>
            <a href="../../index.php">Contato</a>
        </nav>

        <div class="icons">
            <a href="../pages/favorito.php"><img src="https://i.ibb.co/ynVyBhq2/favorite.png"></a>
            <a href="../pages/carrinho.php"><img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png"></a>

            <div class="profile-menu">
                <button type="button" class="profile-btn">
                    <img src="https://i.ibb.co/4RGqW28z/account-circle.png">
                </button>

                <div class="profile-dropdown">
                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <a href="../pages/perfilUsuario.php">Entrar / Cadastrar</a>
                    <?php else: ?>
                        <p class="profile-hello">
                            Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
                        </p>

                        <a href="../pages/paginaPerfil.php">Página de Perfil</a>

                        <?php if (!empty($_SESSION['usuario_nivel']) && $_SESSION['usuario_nivel'] >= 1): ?>
                            <a href="../pages/admPageDashboard.php">Página de Admin</a>
                        <?php endif; ?>

                        <a href="../scripts/logout.php">Logout</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>


    <section class="fundoPrincipal">

        <div class="cardTituloCarrinho">
            <div class="tituloCarrinho">
                <h1>Carrinho</h1>
                <img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png">
            </div>
        </div>

        <div class="infoSituation">
            <div class="produtoSituation">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png">
                <p>Produtos</p>
            </div>
            <div class="indentificacaoSituation">
                <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png">
                <p>Identificação</p>
            </div>
            <div class="pagamentoSituation">
                <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png">
                <p>Pagamento</p>
            </div>
        </div>

        <div class="itensCarrinho">

            <?php if (empty($carrinho)): ?>
                <p style="text-align:center; font-size:20px; margin-top:30px;">Seu carrinho está vazio 😢</p>

            <?php else: ?>

                <?php foreach ($carrinho as $item):
                    $subtotal = $item['preco'] * $item['qtd'];
                    $total += $subtotal;
                ?>

                <div class="itemCar">
                    <img src="<?= $item['img_link'] ?>" class="imgCar" alt="Produto">
                    <div class="infoCarrinho">

                        <div class="info">
                            <h1>Resumo</h1>
                            <p><?= $item['nome'] ?></p>
                            <p>ID: <?= $item['id'] ?></p>
                        </div>

                        <div class="info">
                            <h1>Quantidade</h1>
                            <input type="number"
                                   min="1"
                                   value="<?= $item['qtd'] ?>"
                                   class="inputQtd"
                                   onchange="location.href='../scripts/alterarQtd.php?id=<?= $item['id'] ?>&op=qtd&v='+this.value">
                        </div>

                        <div class="infoPreco">
                            <h1>Preço unitário</h1>
                            <p>R$<?= number_format($item['preco'], 2, ',', '.') ?></p>
                        </div>

                        <div class="infoPrecoF">
                            <h1>Preço final</h1>
                            <p><strong>R$<?= number_format($subtotal, 2, ',', '.') ?></strong></p>
                        </div>
                    </div>

                    <div class="deleteItem">
                        <a href="../scripts/alterarQtd.php?id=<?= $item['id'] ?>&op=remover">
                            <img src="https://i.ibb.co/Zzdfgwmf/delete.png">
                        </a>
                    </div>
                </div>

                <?php endforeach; ?>

            <?php endif; ?>
        </div>

        <div class="finalizarCompra">
            <div class="totalCompra">
                <h1>Total da compra</h1>
                <p class="resultadoFinal">R$<?= number_format($total, 2, ',', '.') ?></p>
            </div>

            <div class="finalizarButton">
                <a href="<?= empty($carrinho) ? '#' : '../pages/resumoPagamento.php'; ?>">
                    <button <?= empty($carrinho) ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '' ?>>
                        Avançar
                    </button>
                </a>
            </div>
        </div>

        <footer id="contato">
            <div class="footerLogo">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" class="logo">
                <h1>VINIL <br>DE RUA</h1>
            </div>

            <div class="avisosFooter">
                <p>Duvidas? (11) 4002-8922 (SP)</p>
                <p>Seg a Sex, 9h às 21h Sáb 10h às 18h</p>
            </div>

            <div class="termos">
                <a href="#">Termos e Condições</a>
            </div>
        </footer>
    </section>

    <script src="../scripts/navbar.js"></script>
    <script src="../scripts/loading.js"></script>
    <script src="../scripts/profileScript.js"></script>

</body>
</html>
