<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoria - Drill</title>
    <!-- FONTES USADASS -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    <link rel="stylesheet" href="../styles/styleCategorias.css">
    <link rel="shortcut icon" type="imagex/png" href="../images/logoVinilDeRua.svg">

</head>


<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading" border="0">
    </div>

    <header>
        <div class="logoHeader">
            <a href="/VinilDeRua-main/vinil de rua/index.php"><img
                    src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="logo-Vinil-De-Rua" border="0"></a>
            <p>VINIL <br>DE RUA</p>
        </div>
        <nav>
            <a href="/VinilDeRua-main/vinil de rua/index.php">Cátalogo</a>
            <a href="/VinilDeRua-main/vinil de rua/index.php">Ofertas</a>
            <a href="/VinilDeRua-main/vinil de rua/index.php">Contato</a>
        </nav>
        <div class="icons">
            <a href="../pages/favorito.php"><img src="https://i.ibb.co/ynVyBhq2/favorite.png" alt="favorite"></a>

            <a href="../pages/carrinho.php"><img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png"
                    alt="shopping-cart"></a>

            <div class="profile-menu">
                <button type="button" class="profile-btn">
                    <img src="https://i.ibb.co/4RGqW28z/account-circle.png" alt="account-circle">
                </button>

                <div class="profile-dropdown">
                    <?php if (!isset($_SESSION['usuario_id'])): ?>

                    <!-- Não logado: só botão de login/cadastro -->
                    <a href="src/assets/pages/perfilUsuario.php">Entrar / Cadastrar</a>

                    <?php else: ?>

                    <p class="profile-hello" style="font-family: Arial, Helvetica, sans-serif;">
                        Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
                    </p>

                    <a href="src/assets/pages/paginaPerfil.php"
                        style="font-family: Arial, Helvetica, sans-serif;">Página de Perfil</a>

                    <?php if (!empty($_SESSION['usuario_nivel']) && $_SESSION['usuario_nivel'] >= 1): ?>
                    <a href="src/assets/pages/adminDashboard.php"
                        style="font-family: Arial, Helvetica, sans-serif;">Página de Admin</a>
                    <?php endif; ?>

                    <a href="../scripts/logout.php" style="font-family: Arial, Helvetica, sans-serif;">Logout</a>

                    <?php endif; ?>
                </div>
            </div>
    </header>
    <main>
        <div class="conteiner">
            <img src="https://i.ibb.co/TqYgxQTr/drillImg.png" alt="Imagem categoria Drill">
            <span>
                <p>DRILL</p>
            </span>

        </div>
    </main>
    <section class="fundoPrincipal">
        <div class="outrasCategorias">
            <h1>Explorar outras categorias:</h1>
            <div class="categorias">
                <a href="../pages/boombapCategoria.php">Boombap</a>
                <a href="../pages/grimeCategoria.php">Grime</a>
                <a href="../pages/90sCategoria.php">90's - Y2k</a>
                <a href="../pages/r&bCategoria.php">R&B</a>
            </div>
        </div>
        <section class="catalogoCategoria">
            <div class="cardDisco">
                <img src="https://i.ibb.co/YTFLy3Zy/23LP.png" alt="Capa do álbum 23 - Central Cee" class="imgCard">
                <div class="infoDisco">
                    <p class="nomeDisco">23 - Central Cee</p>
                    <p class="precoDisco">R$ 325</p>
                </div>
                <div class="preçoEFavDisco">
                    <button class="btnComprarAgora" onclick="selecionarProduto({
                        id: 1,
                        titulo: '23 - Central Cee',
                        img: 'https://i.ibb.co/YTFLy3Zy/23LP.png',
                        preco: 325
                    })">Comprar agora</button>
                    <div class="cart">
                        <button class="addCarrinho">
                            <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                        </button>
                    </div>
                    <div class="favorite">
                        <a href="/src/assets/pages/favorito.html">
                            <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png" alt="favorito">
                        </a>
                    </div>
                </div>
            </div>

            <div class="cardDisco">
                <img src="https://i.ibb.co/YBJJc8Pm/errejota-LP.png"
                    alt="Capa do  álbum ErrejotaCultdrill vol.2 - big Bllakk" class="imgCard">
                <div class="infoDisco">
                    <p class="nomeDisco">ErrejotaCultdrill vol.2 - big Bllakk</p>
                    <p class="precoDisco">R$ 65</p>
                </div>
                <div class="preçoEFavDisco">
                    <button class="btnComprarAgora" onclick="selecionarProduto({
                        id: 2,
                        titulo: 'ErrejotaCultdrill vol.2 - big Bllakk',
                        img: 'https://i.ibb.co/YBJJc8Pm/errejota-LP.png',
                        preco: 65
                    })">Comprar agora</button>
                    <div class="cart">
                        <button class="addCarrinho">
                            <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                        </button>
                    </div>
                    <div class="favorite">
                        <a href="/src/assets/pages/favorito.html">
                            <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png" alt="favorito">
                        </a>
                    </div>
                </div>
            </div>

            <div class="cardDisco">
                <img src="https://i.ibb.co/xtwkgMss/rnbLP.png" alt="Capa do álbum Rap dos novos bandidos - Sant"
                    class="imgCard">
                <div class="infoDisco">
                    <p class="nomeDisco">Rap dos novos bandidos - Sant</p>
                    <p class="precoDisco">R$ 60</p>
                </div>
                <div class="preçoEFavDisco">
                    <button class="btnComprarAgora" onclick="selecionarProduto({
                        id: 3,
                        titulo: 'Rap dos novos bandidos - Sant',
                        img: 'https://i.ibb.co/xtwkgMss/rnbLP.png',
                        preco: 60
                    })">Comprar agora</button>
                    <div class="cart">
                        <button class="addCarrinho">
                            <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                        </button>
                    </div>
                    <div class="favorite">
                        <a href="/src/assets/pages/favorito.html">
                            <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png" alt="favorito">
                        </a>
                    </div>
                </div>
            </div>

            <div class="cardDisco">
                <img src="https://i.ibb.co/4Z4NHqdb/finallt-Rich-LP.png" alt="Capa do álbum Finally rich - Chief Keef"
                    class="imgCard">
                <div class="infoDisco">
                    <p class="nomeDisco">Finally rich - Chief Keef</p>
                    <p class="precoDisco">R$ 310</p>
                </div>
                <div class="preçoEFavDisco">
                    <button class="btnComprarAgora" onclick="selecionarProduto({
                        id: 4,
                        titulo: 'Finally rich - Chief Keef',
                        img: 'https://i.ibb.co/4Z4NHqdb/finallt-Rich-LP.png',
                        preco: 310
                    })">Comprar agora</button>
                    <div class="cart">
                        <button class="addCarrinho">
                            <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                        </button>
                    </div>
                    <div class="favorite">
                        <a href="/src/assets/pages/favorito.html">
                            <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png" alt="favorito">
                        </a>
                    </div>
                </div>
            </div>


            <div class="cardDisco">
                <img src="https://i.ibb.co/zVXzdNL2/7220LP.png" alt="Capa do álbum 7220 - Lil Durk" class="imgCard">
                <div class="infoDisco">
                    <p class="nomeDisco">7220 - Lil Durk</p>
                    <p class="precoDisco">R$ 170</p>
                </div>
                <div class="preçoEFavDisco">
                    <button class="btnComprarAgora" onclick="selecionarProduto({
                        id: 5,
                        titulo: '7220 - Lil Durk',
                        img: 'https://i.ibb.co/zVXzdNL2/7220LP.png',
                        preco: 170
                    })">Comprar agora</button>
                    <div class="cart">
                        <button class="addCarrinho">
                            <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                        </button>
                    </div>
                    <div class="favorite">
                        <a href="/src/assets/pages/favorito.html"><img src="https://i.ibb.co/5mHR0sq/favorite-Black.png"
                                alt="favorito"></a>
                    </div>
                </div>
            </div>


            <div class="cardDisco">
                <img src="https://i.ibb.co/NgWYV098/adolessence-LP.png" alt="Capa do  álbum Adolescence - Unknown T"
                    class="imgCard">
                <div class="infoDisco">
                    <p class="nomeDisco">Adolescence - Unknown T</p>
                    <p class="precoDisco">R$ 120</p>
                </div>
                <div class="preçoEFavDisco">
                    <button class="btnComprarAgora" onclick="selecionarProduto({
                        id: 6,
                        titulo: 'Adolescence - Unknown T',
                        img: 'https://i.ibb.co/NgWYV098/adolessence-LP.png',
                        preco: 120
                    })">Comprar agora</button>
                    <div class="cart">
                        <button class="addCarrinho">
                            <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                        </button>
                    </div>
                    <div class="favorite">
                        <a href="/src/assets/pages/favorito.html"><img src="https://i.ibb.co/5mHR0sq/favorite-Black.png"
                                alt="favorito"></a>
                    </div>
                </div>
            </div>


            <div class="cardDisco">
                <img src="https://i.ibb.co/nMxgNgbw/ednaLP.png" alt="Capa do álbum EDNA – Headie One" class="imgCard">
                <div class="infoDisco">
                    <p class="nomeDisco">EDNA – Headie One</p>
                    <p class="precoDisco">R$ 120</p>
                </div>
                <div class="preçoEFavDisco">
                    <button class="btnComprarAgora" onclick="selecionarProduto({
                        id: 7,
                        titulo: 'EDNA – Headie One',
                        img: 'https://i.ibb.co/nMxgNgbw/ednaLP.png',
                        preco: 120
                    })">Comprar agora</button>
                    <div class="cart">
                        <button class="addCarrinho">
                            <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                        </button>
                    </div>
                    <div class="favorite">
                        <a href="/src/assets/pages/favorito.html"><img src="https://i.ibb.co/5mHR0sq/favorite-Black.png"
                                alt="favorito"></a>
                    </div>
                </div>
            </div>


            <div class="cardDisco">
                <img src="https://i.ibb.co/939sY7PC/sftsafm-LP.png"
                    alt="Capa do  álbum Shoot For The Stars Aim For The Moon - Pop Smoke" class="imgCard">
                <div class="infoDisco">
                    <p class="nomeDisco">Shoot For The Stars Aim For The Moon - Pop Smoke</p>
                    <p class="precoDisco">R$ 220</p>
                </div>
                <div class="preçoEFavDisco">
                    <button class="btnComprarAgora" onclick="selecionarProduto({
                        id: 8,
                        titulo: 'Shoot For The Stars Aim For The Moon - Pop Smoke',
                        img: 'https://i.ibb.co/939sY7PC/sftsafm-LP.png',
                        preco: 220
                    })">Comprar agora</button>
                    <div class="cart">
                        <button class="addCarrinho">
                            <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                        </button>
                    </div>
                    <div class="favorite">
                        <a href="/src/assets/pages/favorito.html"><img src="https://i.ibb.co/5mHR0sq/favorite-Black.png"
                                alt="favorito"></a>
                    </div>
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
    <script src="../scripts/telaDeCompra.js"></script>
    <script src="../scripts/profileScript.js"></script>


</body>

</html>