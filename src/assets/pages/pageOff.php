<?php
session_start();
require_once __DIR__ . "/../scripts/conexao.php";

// Gêneros desejados
$generos = ['R&B', 'Grime', 'Boombap', 'Drill'];

$produtosPromo = []; // <-- nome correto

$desconto_percentual = 20; // desconto (20% por exemplo)

// Loop para buscar 2 de cada gênero
foreach ($generos as $g) {
    $stmt = $pdo->prepare("
        SELECT id, nome, autor, preco, img_link 
        FROM produtos 
        WHERE genero = :gen 
        ORDER BY RAND() 
        LIMIT 2
    ");
    $stmt->bindValue(':gen', $g);
    $stmt->execute();

    $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Aplicar desconto em cada produto
    foreach ($lista as &$p) {
        $preco_original = floatval($p['preco']);
        $preco_desconto = $preco_original * (1 - ($desconto_percentual / 100));

        $p['preco_original_formatado'] = number_format($preco_original, 2, ',', '.');
        $p['preco_desconto_formatado'] = number_format($preco_desconto, 2, ',', '.');

        if (!$p['img_link']) {
            $p['img_link'] = "https://i.ibb.co/BrZyvZX/defaultVinyl.png";
        }
    }
    unset($p);

    // juntar no array global
    $produtosPromo = array_merge($produtosPromo, $lista);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CATALOGO OFF</title>
    <!-- FONTES USADASS -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    <link rel="stylesheet" href="../styles/pageOff.css">
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
            <a href="../pages/favorito.html"><img src="https://i.ibb.co/ynVyBhq2/favorite.png"
                    alt="favorite"></a>
            <a href="../pages/carrinho.html"><img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png"
                    alt="shopping-cart"></a>
            <a href="../pages/perfilUsuario.html"><img src="https://i.ibb.co/4RGqW28z/account-circle.png"
                    alt="account-circle"></a>
        </div>
    </header>


    <section class="fundoPrincipal" #catalogoOff>
            <div class="bannerBlackFriday">
                <div class="anuncioBlackFriday">
                    <h1>DESCONTOS BLACK FRIDAY EM DISCOS ATÉ 60% OFF!!</h1>
                </div>

                <div class="campoFiltro">
                    <p>Preço</p>

                    <p id="valorFiltro">Até R$ 500</p>

                    <div class="valores">
                        <p>Min: <br> R$ 0</p>
                        <p>Max: <br> R$ 500</p>
                    </div>

                    <div class="rangeInput">
                        <input type="range" name="filtro" id="filtroPreco" min="0" max="500" value="500">
                    </div>

                    <button id="btnFiltrarPreco">Filtrar</button>
                </div>

            </div>

            <section class="catalogoOff">
                <?php foreach ($produtosPromo as $p): ?>   
                <div class="cardDisco" preco="430">
                    <img src="<?= $p['img_link'] ?>"
                        alt="<?= htmlspecialchars($p['nome']) ?>"
                        class="imgCard">
                    <div class="infoDisco">
                        <p class="nomeDisco"><?= htmlspecialchars($p['nome']) ?></p>
                        <p class="nomeDisco"><?= htmlspecialchars($p['autor']) ?></p>

                        <p class="precoDisco" style="text-decoration: line-through; color: #b1b1b1;">
                            R$ <?= $p['preco_original_formatado'] ?>
                        </p>

                        <p class="precoDisco" style="color: red; font-weight:bold;">
                            R$ <?= $p['preco_desconto_formatado'] ?>
                        </p>
                    </div>
                    <div class="preçoEFavDisco">
                        <button class="btnComprarAgora"
                            onclick="window.location.href='../scripts/addCarrinho.php?id=<?= $p['id'] ?>&redirect=carrinho'">
                            Comprar agora
                        </button>

                        <div class="cart">
                            <a href="../scripts/addCarrinho.php?id=<?= $p['id'] ?>">
                                <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png">
                            </a>
                        </div>

                        <div class="favorite">
                            <a href="../pages/favorito.php?id=<?= $p['id'] ?>">
                                <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png">
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            </div>
            </section>


            <footer id="contato">
                <div class="footerContainer">
                    <div class="footerLogo">
                        <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="Vinil de Rua" class="logo">
                        <h1>VINIL <br>DE RUA</h1>
                    </div>
                    <div class="socialConteiner">
                        <div class="footerCtt">
                            <h1>Contato</h1>
                            <hr>
                            <p>contato@vinilderua.com.br</p>
                            <p>(11) 11 4002-8922</p>
                        </div>
                        <p class="social">Nos siga:</p>
                        <div class="socialLogo">
                            <img style="cursor: pointer;" onclick="window.open('https://wa.me/5511945859221', '_blank')"
                                src="https://i.ibb.co/d0pJB3H5/zapLogo.png" alt="WhatsApp">
                            <img style="cursor: pointer;"
                                onclick="window.open('https://www.instagram.com/duudjs_/', '_blank')"
                                src="https://i.ibb.co/Gv2fVPqD/insta-Logo.png" alt="Instagram">
                            <img style="cursor: pointer;" onclick="window.open('https://br.pinterest.com/', '_blank')"
                                src="https://i.ibb.co/BKNqDc8Z/pinterest-Logo.png" alt="Pinterest">
                            <img style="cursor: pointer;" onclick="window.open('https://www.facebook.com/', '_blank')"
                                src="https://i.ibb.co/SXZ6bhxx/faceLogo.png" alt="Facebook">
                        </div>
                    </div>
                    <div class="formasPagamento">
                        <h1>Formas de pagamento</h1>
                        <hr>
                        <div class="formasPagamentoImg">
                            <a href="https://ibb.co/5gLxyp3k"><img src="https://i.ibb.co/Zpx1P4rS/fiadoPay.png"
                                    alt="fiadoPay"></a>
                            <a href=""><img src="https://i.ibb.co/PGTbDWv8/applePay.png" alt="applePay"></a>
                            <a href=""><img src="https://i.ibb.co/j9xwJZxb/google-Pay.png" alt="google-Pay"></a>
                            <a href=""><img src="https://i.ibb.co/Jw4Fw4Q4/mastercard-Pay.png" alt="mastercard-Pay"></a>
                            <a href=""><img src="https://i.ibb.co/WpgW73SM/pixPay.png" alt="pixPay" </a>
                                <a href=""><img src="https://i.ibb.co/RGHkXJks/visaPay.png" alt="visaPay"></a>
                        </div>
                    </div>
                </div>
                <div class="copyrightVdR">
                    <p>Copyright © 2025 Vinil de Rua </p>
                </div>
            </footer>
    </section>

    <script src="../scripts/navbar.js"></script>
    <script src="../scripts/loading.js"></script>
    <script src="../scripts/carrinho.js"></script>
    <script src="../scripts/conexão.js"></script>
    <script src="../scripts/filtro.js"></script>


</body>

</html>