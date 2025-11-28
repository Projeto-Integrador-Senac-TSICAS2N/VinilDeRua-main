<?php 
session_start();
require_once __DIR__ . "/../scripts/conexao.php";

// Buscar produtos do gênero DRILL
$stmt = $pdo->prepare("SELECT id, nome, autor, preco, img_link FROM produtos WHERE genero = 'DRILL'");
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categoria - Drill</title>

    <!-- FONTES -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../styles/styleCategorias.css">
    <link rel="shortcut icon" type="image/png" href="../images/logoVinilDeRua.svg">
</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
    </div>

    <header>
        <div class="logoHeader">
            <a href="/VinilDeRua-main/vinil de rua/index.php">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="Logo">
            </a>
            <p>VINIL <br>DE RUA</p>
        </div>

        <nav>
            <a href="/VinilDeRua-main/vinil de rua/index.php">Catálogo</a>
            <a href="/VinilDeRua-main/vinil de rua/index.php">Ofertas</a>
            <a href="/VinilDeRua-main/vinil de rua/index.php">Contato</a>
        </nav>

        <div class="icons">
            <a href="../pages/favorito.php"><img src="https://i.ibb.co/ynVyBhq2/favorite.png"></a>
            <a href="../pages/carrinho.php"><img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png"></a>
            <a href="../pages/perfilUsuario.php"><img src="https://i.ibb.co/4RGqW28z/account-circle.png"></a>
        </div>
    </header>

    <main>
        <div class="conteiner">
            <img src="https://i.ibb.co/TqYgxQTr/drillImg.png" alt="Imagem categoria Drill">
            <span><p>DRILL</p></span>
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

            <?php if (empty($produtos)): ?>

                <h2 style="text-align:center; margin-top:20px;">Nenhum vinil de DRILL disponível 😢</h2>

            <?php else: ?>

                <?php foreach ($produtos as $p): ?>
                    <?php
                        $id = $p['id'];
                        $nome = $p['nome'];
                        $autor = $p['autor'];
                        $preco = number_format($p['preco'], 2, ',', '.');
                        $img = $p['img_link'] ?: "https://i.ibb.co/BrZyvZX/defaultVinyl.png";
                    ?>

                    <div class="cardDisco">

                        <img src="<?= $img ?>" alt="<?= htmlspecialchars($nome) ?>" class="imgCard">

                        <div class="infoDisco">
                            <p class="nomeDisco"><?= htmlspecialchars($nome) ?></p>
                            <p class="nomeDisco"><?= htmlspecialchars($autor) ?></p>
                            <p class="precoDisco">R$ <?= $preco ?></p>
                        </div>

                        <div class="preçoEFavDisco">
                            <button class="btnComprarAgora"
                                onclick="window.location.href='../scripts/addCarrinho.php?id=<?= $id ?>&redirect=carrinho'">
                                Comprar agora
                            </button>

                            <div class="cart">
                                <a href="../scripts/addCarrinho.php?id=<?= $id ?>">
                                    <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png">
                                </a>
                            </div>

                            <div class="favorite">
                                <a href="../pages/favorito.php?id=<?= $id ?>">
                                    <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png">
                                </a>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php endif; ?>

        </section>

        <footer>
            <div class="copyrightVdR">
                <p>Copyright © 2025 Vinil de Rua</p>
            </div>
        </footer>
    </section>

    <script src="../scripts/navbar.js"></script>
    <script src="../scripts/loading.js"></script>
    <script src="../scripts/profileScript.js"></script>

</body>
</html>
