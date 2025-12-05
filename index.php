<?php
session_start();
require_once __DIR__ . "/src/assets/scripts/conexao.php";

// Gêneros desejados
$generos = ["Grime", "Boombap", "Drill", "R&B"];

$produtosFixos = [];

// Puxa 2 discos por gênero
foreach ($generos as $g) {
  $stmt = $pdo->prepare("
        SELECT id, nome, autor, preco, img_link
        FROM produtos
        WHERE genero = :gen
        ORDER BY RAND()
        LIMIT 2
    ");
  $stmt->execute([':gen' => $g]);

  $produtosFixos = array_merge($produtosFixos, $stmt->fetchAll(PDO::FETCH_ASSOC));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Vinil de Rua - Home</title>
  <!-- FONTES USADASS -->
  <link
    href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap"
    rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Anton&display=swap"
    rel="stylesheet" />
  <link
    href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap"
    rel="stylesheet" />
  <!-- SEPARAÇÃO -->
  <link rel="stylesheet" href="src/assets/styles/styleIndex.css" />
  <link
    rel="shortcut icon"
    type="imagex/png"
    href="/VinilDeRua-main/vinil de rua/src/assets/images/logoVinilDeRua.svg" />
</head>

<body>
  <div id="preloader">
    <img
      src="https://i.ibb.co/qYwvJYpw/loading.gif"
      alt="loading"
      border="0" />
  </div>

  <header>
    <div class="logoHeader">
      <a href="index.php"><img
          src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png"
          alt="logo-Vinil-De-Rua"
          border="0" /></a>
      <p>VINIL <br />DE RUA</p>
    </div>
    <nav>
      <a href="#catalogo">Cátalogo</a>
      <a href="/VinilDeRua-main/vinil de rua/src/assets/pages/pageOff.php">Ofertas</a>
      <a href="#contato">Contato</a>
    </nav>
    <div class="icons">
      <a href="src/assets/pages/favorito.php"><img src="https://i.ibb.co/ynVyBhq2/favorite.png"
          alt="favorite"></a>

      <a href="src/assets/pages/carrinho.php"><img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png"
          alt="shopping-cart"></a>

      <div class="profile-menu">
        <button type="button" class="profile-btn">
          <img src="https://i.ibb.co/4RGqW28z/account-circle.png" alt="account-circle">
        </button>

        <div class="profile-dropdown">
          <?php if (!isset($_SESSION['usuario_id'])): ?>

            <!-- Não logado: só botão de login/cadastro -->
            <a href="src/assets/pages/perfilUsuario.php" style="font-family: Arial, Helvetica, sans-serif;">Entrar / Cadastrar</a>

          <?php else: ?>

            <p class="profile-hello" style="font-family: Arial, Helvetica, sans-serif;">
              Olá, <?= htmlspecialchars($_SESSION['usuario_nome']) ?>
            </p>

            <a href="src/assets/pages/perfil.php" style="font-family: Arial, Helvetica, sans-serif;">Página de Perfil</a>

            <?php if (!empty($_SESSION['usuario_nivel']) && $_SESSION['usuario_nivel'] >= 1): ?>
              <a href="src/assets/pages/admPageDashboard.php" style="font-family: Arial, Helvetica, sans-serif;">Página de Admin</a>
            <?php endif; ?>

            <a href="src/assets/scripts/logout.php" style="font-family: Arial, Helvetica, sans-serif;">Logout</a>

          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>
  <main>
    <section class="conteiner">
      <div class="textConteiner">
        <h1>
          <span>Vinil de Rua</span> o site feito para quem ama música de
          verdade
        </h1>
        <p>Confira agora nosso catálogo, com discos até 70% de desconto.</p>
      </div>
      <div class="imageHero">
        <img src="src/assets/images/imageHero.png" alt="" />
        <!-- <img src="discoVinilDeRua.gif" class="discoGrirando" alt="">
            <img src=".../fundoHero.png" class="fundo" alt="">
            <img src=".../sabotaHero.png" class="imgSabota" alt=""> -->
      </div>
    </section>
  </main>
  <section class="fundoPrincipal">
    <section class="offECatalogo" id="catalogo">
      <div class="cardOff">
        <div class="linkEImg">
          <div class="offEimg">
            <h1>70% OFF LIMITADO!</h1>
            <a href="/VinilDeRua-main/vinil de rua/src/assets/pages/pageOff.php" class="offDisco">VEJA MAIS AQUI</a>
          </div>
          <img src="https://i.ibb.co/yckTbjhV/paleta.png" alt="">
        </div>
        <div class="listaDiscos">
          <div class="cardDiscoOff">
            <img src="https://i.ibb.co/jZq6YsFN/amlLP.png"
              alt="Capa do  álbum Awaken, my love - Childish Gambino" class="imgCard">
            <div class="infoDisco">
              <p class="nomeDisco">Awaken, my love - Childish Gambino</p>
              <p class="offDisco">60% Off</p>
            </div>
          </div>

          <div class="cardDiscoOff">
            <img src="https://i.ibb.co/jZq6YsFN/amlLP.png"
              alt="Capa do  álbum Awaken, my love - Childish Gambino" class="imgCard">
            <div class="infoDisco">
              <p class="nomeDisco">Awaken, my love - Childish Gambino</p>
              <p class="offDisco">60% Off</p>
            </div>
          </div>
          <div class="cardDiscoOff">
            <img src="https://i.ibb.co/jZq6YsFN/amlLP.png"
              alt="Capa do  álbum Awaken, my love - Childish Gambino" class="imgCard">
            <div class="infoDisco">
              <p class="nomeDisco">Awaken, my love - Childish Gambino</p>
              <p class="offDisco">60% Off</p>
            </div>
          </div>
          <div class="cardDiscoOff">
            <img src="https://i.ibb.co/jZq6YsFN/amlLP.png"
              alt="Capa do  álbum Awaken, my love - Childish Gambino" class="imgCard">
            <div class="infoDisco">
              <p class="nomeDisco">Awaken, my love - Childish Gambino</p>
              <p class="offDisco">60% Off</p>
            </div>
          </div>
        </div>
      </div>

      <div class="catalogoIndex">

        <!-- 1 -->
        <?php foreach ($produtosFixos as $p):
          $img   = $p['img_link'] ?: "https://i.ibb.co/BrZyvZX/defaultVinyl.png";
          $preco = number_format($p['preco'], 2, ',', '.');
        ?>
          <div class="cardDisco">

            <img src="<?= $img ?>" class="imgCard">

            <div class="infoDisco">
              <p class="nomeDisco"><?= htmlspecialchars($p['nome']) ?></p>
              <p class="precoDisco">R$ <?= $preco ?></p>
            </div>

            <div class="preçoEFavDisco">

              <button onclick="window.location.href='src/assets/scripts/addCarrinho.php?id=<?= $p['id'] ?>'"
                class="btnComprarAgora">
                Comprar agora
              </button>

              <div class="cart">
                <a href="src/assets/scripts/addCarrinho.php?id=<?= $p['id'] ?>">
                  <img src="https://i.ibb.co/6RFY694G/add-shopping-cart-1.png">
                </a>
              </div>

              <div class="favorite">
                <a href="src/assets/scripts/toggleFavorito.php?id=<?= $p['id'] ?>">
                  <img src="https://i.ibb.co/5mHR0sq/favorite-Black.png">
                </a>
              </div>

            </div>
          </div>
        <?php endforeach; ?>


      </div>

    </section>

    <div class="btnVerMais">
      <button>
        Ver Mais <img src="https://i.ibb.co/67tJkVFM/setaTop.png" alt="" />
      </button>
    </div>

    <section class="explorarCategorias">
      <h1>Explorar por categorias</h1>
      <div class="categorias">
        <button
          class="cardCategorias"
          onclick="window.open('src/assets/pages/grimeCategoria.php', '_self')">
          <img
            src="https://i.ibb.co/k6vwycqQ/categoria-Grime.png"
            alt="Imagem categoria Grime" />
          <span>
            <p>GRIME</p>
          </span>
        </button>
        <button
          class="cardCategorias"
          onclick="window.open('src/assets/pages/boombapCategoria.php', '_self')">
          <img
            src="https://i.ibb.co/kgjd0pzW/categoria-Boombap.png"
            alt="Imagem categoria Boombap" />
          <span>
            <p>BOOMBAP</p>
          </span>
        </button>
        <button
          class="cardCategorias"
          onclick="window.open('src/assets/pages/drillCategoria.php', '_self')">
          <img
            src="https://i.ibb.co/8D26WkNj/categoria-Drill.png"
            alt="Imagem categoria Drill" />
          <span>
            <p>DRILL</p>
          </span>
        </button>
        <button
          class="cardCategorias"
          onclick="window.open('src/assets/pages/90sCategoria.php', '_self')">
          <img
            src="https://i.ibb.co/Zp4sBT0j/categoria90-Y2k.png"
            alt="Imagem categoria 90's-Y2k" />
          <span>
            <p>90'S - Y2K</p>
          </span>
        </button>
        <button
          class="cardCategorias"
          onclick="window.open('src/assets/pages/r&bCategoria.php', '_self')">
          <img
            src="https://i.ibb.co/zTHF5LNC/categoria-R-B.png"
            alt="Imagem categoria R&B" />
          <span>
            <p>R&B</p>
          </span>
        </button>
      </div>
    </section>

    <footer id="contato">
      <div class="footerContainer">
        <div class="footerLogo">
          <img
            src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png"
            alt="Vinil de Rua"
            class="logo" />
          <h1>VINIL <br />DE RUA</h1>
        </div>
        <div class="socialConteiner">
          <div class="footerCtt">
            <h1>Contato</h1>
            <hr />
            <p>contato@vinilderua.com.br</p>
            <p>(11) 11 4002-8922</p>
          </div>
          <p class="social">Nos siga:</p>
          <div class="socialLogo">
            <img
              style="cursor: pointer"
              onclick="window.open('https://wa.me/5511945859221', '_blank')"
              src="https://i.ibb.co/d0pJB3H5/zapLogo.png"
              alt="WhatsApp" />
            <img
              style="cursor: pointer"
              onclick="window.open('https://www.instagram.com/duudjs_/', '_blank')"
              src="https://i.ibb.co/Gv2fVPqD/insta-Logo.png"
              alt="Instagram" />
            <img
              style="cursor: pointer"
              onclick="window.open('https://br.pinterest.com/', '_blank')"
              src="https://i.ibb.co/BKNqDc8Z/pinterest-Logo.png"
              alt="Pinterest" />
            <img
              style="cursor: pointer"
              onclick="window.open('https://www.facebook.com/', '_blank')"
              src="https://i.ibb.co/SXZ6bhxx/faceLogo.png"
              alt="Facebook" />
          </div>
        </div>
        <div class="formasPagamento">
          <h1>Formas de pagamento</h1>
          <hr />
          <div class="formasPagamentoImg">
            <a href="https://ibb.co/5gLxyp3k"><img
                src="https://i.ibb.co/Zpx1P4rS/fiadoPay.png"
                alt="fiadoPay" /></a>
            <a href=""><img
                src="https://i.ibb.co/PGTbDWv8/applePay.png"
                alt="applePay" /></a>
            <a href=""><img
                src="https://i.ibb.co/j9xwJZxb/google-Pay.png"
                alt="google-Pay" /></a>
            <a href=""><img
                src="https://i.ibb.co/Jw4Fw4Q4/mastercard-Pay.png"
                alt="mastercard-Pay" /></a>
            <a href=""><img src="https://i.ibb.co/WpgW73SM/pixPay.png" alt="pixPay"
                </a>
              <a href=""><img src="https://i.ibb.co/RGHkXJks/visaPay.png" alt="visaPay" /></a>
          </div>
        </div>
      </div>
      <div class="copyrightVdR">
        <p>Copyright © 2025 Vinil de Rua</p>
      </div>
    </footer>
  </section>

  <div vw class="enabled">
    <div vw-access-button class="active"></div>
    <div vw-plugin-wrapper>
      <div class="vw-plugin-top-wrapper"></div>
    </div>
  </div>
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
  <script>
    new window.VLibras.Widget("https://vlibras.gov.br/app");
  </script>

  <script src="/VinilDeRua-main/vinil%20de%20rua/src/assets/scripts/navbar.js"></script>
  <script src="/VinilDeRua-main/vinil%20de%20rua/src/assets/scripts/loading.js"></script>
  <script src="/VinilDeRua-main/vinil%20de%20rua/src/assets/scripts/carrinho.js"></script>
  <script src="/VinilDeRua-main/vinil%20de%20rua/src/assets/scripts/conexão.js"></script>
  <script src="/VinilDeRua-main/vinil%20de%20rua/src/assets/scripts/favorito.js"></script>
  <script src="/VinilDeRua-main/vinil%20de%20rua/src/assets/scripts/profileScript.js"></script>

</body>

</html>