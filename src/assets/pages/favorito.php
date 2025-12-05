<?php
session_start();
require_once __DIR__ . "/../scripts/protecaoLogin.php";
require_once __DIR__ . "/../scripts/conexao.php";

$usuarioId = $_SESSION['usuario_id'];

// Buscar favoritos do usuário
$stmt = $pdo->prepare("
    SELECT p.id, p.nome, p.autor, p.preco, p.img_link
    FROM favoritos f
    JOIN produtos p ON p.id = f.produto_id
    WHERE f.usuario_id = :u
    ORDER BY f.data_favorito DESC
");
$stmt->execute([':u' => $usuarioId]);
$favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Favoritos - Vinil de Rua</title>
    <!-- FONTES USADASS -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    <link rel="stylesheet" href="..//styles/styleFav.css">
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
            <p>Vinil <br>de Rua</p>
        </div>
        <nav>
            <a href="/VinilDeRua-main/vinil de rua/index.php">Cátalogo</a>
            <a href="/VinilDeRua-main/vinil de rua/index.php">Ofertas</a>
            <a href="/VinilDeRua-main/vinil de rua/index.php">Contato</a>
        </nav>
        <div class="icons">
            <div class="icons">
                <a href="../pages/favorito.php"><img src="https://i.ibb.co/ynVyBhq2/favorite.png"
                        alt="favorite"></a>

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

                            <a href="src/assets/pages/paginaPerfil.php" style="font-family: Arial, Helvetica, sans-serif;">Página de Perfil</a>

                            <?php if (!empty($_SESSION['usuario_nivel']) && $_SESSION['usuario_nivel'] >= 1): ?>
                                <a href="src/assets/pages/adminDashboard.php" style="font-family: Arial, Helvetica, sans-serif;">Página de Admin</a>
                            <?php endif; ?>

                            <a href="../scripts/logout.php" style="font-family: Arial, Helvetica, sans-serif;">Logout</a>

                        <?php endif; ?>
                    </div>
                </div>
            </div>

    </header>


    <section class="fundoPrincipal">


        <section class="cardsFav">
            <?php if (empty($favoritos)): ?>

                <p style="color: #fff; font-family: 'Young Serif', serif; font-size: 24px;">
                    Você ainda não tem favoritos 💿
                    <br>Adicione alguns no catálogo!
                </p>

            <?php else: ?>

                <?php foreach ($favoritos as $p):
                    $img   = $p['img_link'] ?: "https://i.ibb.co/BrZyvZX/defaultVinyl.png";
                    $preco = number_format($p['preco'], 2, ',', '.');
                ?>
                    <div class="cardDisco">

                        <img src="<?= $img ?>"
                            alt="<?= htmlspecialchars($p['nome']) ?>"
                            class="imgCard">

                        <div class="infoDisco">
                            <p class="nomeDisco"><?= htmlspecialchars($p['nome']) ?> - <?= htmlspecialchars($p['autor']) ?></p>
                            <p class="precoDisco">R$ <?= $preco ?></p>
                        </div>

                        <div class="preçoEFavDisco">

                            <button class="btnComprarAgora"
                                onclick="window.location.href='../scripts/addCarrinho.php?id=<?= $p['id'] ?>&redirect=carrinho'">
                                Comprar agora
                            </button>

                            <div class="cart">
                                <a href="../scripts/addCarrinho.php?id=<?= $p['id'] ?>">
                                    <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png" alt="carrinho">
                                </a>
                            </div>

                            <div class="favorite">
                                <a href="../scripts/toggleFavorito.php?id=<?= $p['id'] ?>&redirect=favoritos">
                                    <img src="https://i.ibb.co/b5vJrSGP/favorite-Red.png" alt="remover favorito">
                                </a>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>


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
    <script src="../scripts/favorito.js"></script>
    <script src="../scripts/profileScript.js"></script>
</body>

</html>