<?php
session_start();
require_once "../scripts/conexao.php";

// ---------- IMPEDIR ACESSO SEM LOGIN ----------
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Você precisa estar logado para continuar.'); window.location='../pages/login.php';</script>";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// ---------- IMPEDIR ACESSO SEM CARRINHO ----------
if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
    echo "<script>alert('Seu carrinho está vazio!'); window.location='../pages/carrinho.php';</script>";
    exit;
}

// ---------- BUSCAR DADOS DO USUÁRIO ----------
$sqlUser = "SELECT nome, email FROM usuarios WHERE id = $usuario_id";
$user = mysqli_fetch_assoc(mysqli_query($con, $sqlUser));

// ---------- BUSCAR ENDEREÇO ----------
$sqlEndereco = "SELECT * FROM enderecos WHERE usuario_id = $usuario_id LIMIT 1";
$endereco = mysqli_fetch_assoc(mysqli_query($con, $sqlEndereco));

// ---------- BUSCAR TELEFONE ----------
$sqlTel = "SELECT numero_usuario FROM telefones WHERE usuario_id = $usuario_id LIMIT 1";
$telefone = mysqli_fetch_assoc(mysqli_query($con, $sqlTel));
$telefone = $telefone ? $telefone['numero_usuario'] : "Não informado";

// ---------- BUSCAR ITENS DO CARRINHO ----------
$produtos = [];
$totalProdutos = 0;

foreach ($_SESSION['carrinho'] as $id => $qtd) {
    $sql = "SELECT id, nome, preco, img_link FROM produtos WHERE id = $id LIMIT 1";
    $res = mysqli_query($con, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $p = mysqli_fetch_assoc($res);
        $p['quantidade'] = is_array($qtd) ? intval($qtd['quantidade'] ?? 1) : intval($qtd);
        $p['subtotal'] = floatval($p['preco']) * intval($qtd);
        $totalProdutos += $p['subtotal'];
        $produtos[] = $p;
    }
}

// Taxa fixa fictícia
$valorEntrega = 10.00;
$totalGeral = $totalProdutos + $valorEntrega;
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo da compra</title>
    <!-- FONTES USADASS -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    <link rel="stylesheet" href="../styles/resumoCompra.css">
    <link rel="shortcut icon" type="imagex/png" href="../images/logoVinilDeRua.svg">

</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading" border="0">
    </div>

    <header>
        <div class="logoHeader">
            <a href="/VinilDeRua-main/vinil de rua/index.php"><img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png"
                    alt="logo-Vinil-De-Rua" border="0"></a>
            <p>VINIL <br>DE RUA</p>
        </div>
        <nav>
            <a href="/index.html#catalogo">Cátalogo</a>
            <a href="../pages/pageOff.html#catalogoOff">Ofertas</a>
            <a href="#contato">Contato</a>
        </nav>
        <div class="icons">
            <a href="../pages/favorito.php"><img src="https://i.ibb.co/ynVyBhq2/favorite.png"
                    alt="favorite"></a>
            <a href="../pages/carrinho.php"><img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png"
                    alt="shopping-cart"></a>
            <a href="../pages/perfilUsuario.php"><img src="https://i.ibb.co/4RGqW28z/account-circle.png"
                    alt="account-circle"></a>
        </div>
    </header>


    <section class="fundoPrincipal">

        <div class="infoSituation">
            <div class="produtoSituation">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="logo Vinil De Rua">
                <p>Produtos</p>
            </div>
            <div class="indentificacaoSituation">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="logo Vinil De Rua">
                <p>Indentificação</p>
            </div>
            <div class="pagamentoSituation">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="logo Vinil De Rua">
                <p>Pagamento</p>
            </div>
        </div>



        <section class="resumoCompra">

            <div class="txtResumo">
                <h1>Resumo da compra:</h1>
            </div>

            <section class="cardsInfos">
                <div class="cardResumo">
                    <div class="tituloEditar">
                        <h1>Contato:</h1>
                        <a href="../pages/perfilUsuario.php">Editar</a>
                    </div>
                    <p><?= htmlspecialchars($user['email']) ?></p>
                </div>

                <div class="cardResumo">
                    <div class="tituloEditar">
                        <h1>Endereço:</h1>
                        <a href="../pages/perfilUsuario.php">Editar</a>
                    </div>
                    <p><?= $user['nome'] ?></p>
                    <p><?= $endereco['Logradouro'] ?></p>
                    <p><?= $endereco['CEP'] ?></p>
                    <p><?= $endereco['Cidade'] ?> - <?= $endereco['Estado'] ?></p>
                    <p><?= $endereco['complemento'] ?: 'Sem complemento' ?></p>
                    <p><?= $telefone ?></p>
                </div>

                <div class="cardResumo">
                    <div class="tituloEditar">
                        <h1>Opções de entrega:</h1>
                        <a href="">Editar</a>
                    </div>
                    <p>Entrega agendada</p>
                    <p><?= date('d/m/Y', strtotime('+2 days')) ?> — 10:00 às 12:40</p>
                    <p>R$<?= number_format($valorEntrega, 2, ',', '.') ?></p>
                </div>

            </section>

            <div class="pedidoFinal">

                <div class="cardResumo">
                    <div class="tituloEditar">
                        <h1>Seu pedido</h1>
                        <a href="../pages/carrinho.php">Editar</a>
                    </div>

                    <div class="produtosFinais">

                        <?php foreach ($produtos as $item): ?>

                            <?php
                            // 🔥 corrigir categoria
                            $categoriaTexto = ($item["categoria"] ?? 0) == 0 ? "Vinil" : "Vitrola";
                            ?>

                            <div class="produtoItem">
                                <img src="<?= $item['img_link'] ?>" style="width:330px; height:330px; object-fit:cover; border-radius:10px;">
                                <div class="infosFinais">
                                    <h1><?= $item['nome'] ?></h1>
                                    <p><strong>Categoria:</strong> <?= $categoriaTexto ?></p>
                                    <p><strong>Preço unitário:</strong> R$<?= number_format($item['preco'], 2, ',', '.') ?></p>
                                    <p><strong>Quantidade:</strong> <?= $item['quantidade'] ?></p>
                                    <p><strong>Subtotal:</strong> R$<?= number_format($item['subtotal'], 2, ',', '.') ?></p>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>

                    <div class="infosPessoaisCompra">
                        <p>Produtos: <?= count($produtos) ?> - R$<?= number_format($totalProdutos, 2, ',', '.') ?></p>
                        <p>Entrega: R$<?= number_format($valorEntrega, 2, ',', '.') ?></p>
                        <p><strong>Total: R$<?= number_format($totalGeral, 2, ',', '.') ?></strong></p>
                    </div>
                </div>
            </div>

            </div>

            <div class="fazerPagamento">

                <form method="POST" action="../scripts/simulacaoPagamento.php">

                    <div class="formasPagamento">
                        <div class="cardResumSo">
                            <h1>Forma de Pagamento</h1>
                        </div>

                        <div class="cardResumo">
                            <label class="circleCheckbox">
                                <input type="radio" name="payMethod" value="PIX" required>
                                <span></span>
                                <img src="https://i.ibb.co/WpgW73SM/pixPay.png" alt="pixPay">
                                <p>PIX</p>
                            </label>
                        </div>

                        <div class="cardResumo">
                            <label class="circleCheckbox">
                                <input type="radio" name="payMethod" value="Cartão" required>
                                <span></span>
                                <img src="https://i.ibb.co/Jw4Fw4Q4/mastercard-Pay.png" alt="mastercard-Pay">
                                <p>Débito / Crédito</p>
                            </label>
                        </div>

                        <div class="cardResumo">
                            <label class="circleCheckbox">
                                <input type="radio" name="payMethod" value="Boleto" required>
                                <span></span>
                                <img src="https://i.ibb.co/5hGCS8jn/boleto-Pay.png" alt="boletoPay">
                                <p>Boleto</p>
                            </label>
                        </div>

                        <div class="cardResumo">
                            <label class="circleCheckbox">
                                <input type="radio" name="payMethod" value="Fiado" required>
                                <span></span>
                                <img src="https://i.ibb.co/Zpx1P4rS/fiadoPay.png" alt="fiadoPay">
                                <p>Fiado</p>
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="total" value="<?= $totalGeral ?>">

                    <button type="submit" class="btnPagamento">Realizar Pagamento</button>
                </form>

            </div>

            <form method="POST" action="../scripts/simulacaoPagamento.php">
                <input type="hidden" name="total" value="<?= $totalGeral ?>">
                <button type="submit">Realizar Pagamento</button>
            </form>

            </div>
        </section>

        <footer id="contato">
            <div class="footerLogo">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="Vinil de Rua" class="logo">
                <h1>VINIL <br>DE RUA</h1>
            </div>

            <div class="avisosFooter">
                <p>Duvidas? (11) 4002-8922 (SP)</p>
                <p>Seg a Sex, 9h às 21h Sáb 10h às 18h</p>

            </div>
            <div class="termos">
                <a href="">Termos e Condições</a>
            </div>

        </footer>
    </section>

    <script src="../scripts/navbar.js"></script>
    <script src="../scripts/loading.js"></script>
    <script src="../scripts/carrinho.js"></script>
    <script src="../scripts/conexão.js"></script>


</body>

</html>