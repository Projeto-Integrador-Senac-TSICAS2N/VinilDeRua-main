<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- FONTES USADASS -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    <link rel="stylesheet" href="../styles/stylePerfil.css">
    <link rel="shortcut icon" type="imagex/png" href="../images/logoVinilDeRua.svg">
</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading" border="0">
    </div>

    <main>
        <div class="form-container">

            <!-- Tela de Login -->
            <div class="login-box form-box">
                <div class="logoPerfil">
                    <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                    <h1>VINIL <br> DE RUA</h1>
                </div>
                <?php
                session_start();
                if (isset($_SESSION['erro'])) {
                    echo "<p class='alertaErro'>" . $_SESSION['erro'] . "</p>";
                    unset($_SESSION['erro']);
                }

                if (isset($_SESSION['sucesso'])) {
                    echo "<p class='alertaSucesso'>" . $_SESSION['sucesso'] . "</p>";
                    unset($_SESSION['sucesso']);
                }
                ?>

                <div class="infoUser">
                    <form action="../scripts/login.php" method="POST">
                        <input type="text" placeholder="EMAIL" class="inputUser" name="email">
                        <div id="input" class="inputSenha">
                            <input type="password" placeholder="SENHA" class="inputPass" id="input" name="senha">
                            <img src="https://i.ibb.co/0R4T4YRv/olhoDeR.png" alt="">
                        </div>  
                    </div>
                    <div class="buttonLogin">
                        <button id="criarConta">LOGIN</button>
                    </div>
                </form>
                <div class="buttonLogin">
                    <button id="criarConta" onclick="window.open('../pages/cadastrarUser.php', '_self')">CRIAR CONTA</button>
                </div>
                    <div class="esqueceuSenha">
                    <span><a href="#" onclick="showForgot()">Esqueceu a sua senha?</a></span>
                </div>
            </div>

            <!-- Tela de Recuperar Senha -->
            <div class="forgot-box form-box">
                <div class="logoPerfil">
                    <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                    <h1>VINIL <br> DE RUA</h1>
                </div>
                <div class="mensagemErro">
                    <h1>Calma! Iremos recuperar sua senha.</h1>
                </div>
                <div class="infoUser">
                    <input type="email" placeholder="EMAIL" class="inputUser">
                    <input type="password" placeholder="SENHA NOVA" class="inputUser">
                </div>

                <div class="buttonLogin">
                    <button id="recuperarSenha">ENVIAR</button>
                </div>
                <div class="esqueceuSenha">
                    <span><a href="#" onclick="showLogin()">Voltar ao login</a></span>
                </div>
            </div>


    </main>


    <script src="../scripts/navbar.js"></script>
    <script src="../scripts/loading.js"></script>
    <script src="../scripts/trocaLogin.js"></script>
</body>

</html> 