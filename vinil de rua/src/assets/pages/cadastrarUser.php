<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
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


            <div class="criarConta-box form-box">
                <div class="logoPerfil">
                    <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                    <h1>VINIL <br> DE RUA</h1>
                </div>

                <div class="mensagemErro">
                    <h1>Seja Bem-vindo(a) ao Vinil de Rua!</h1>
                </div>
                <form action="/VinilDeRua-main/vinil de rua/src/assets/scripts/cadastrar_User.php" method="POST">
                    <div class="infoUser">
                        <input type="text" name="nome" placeholder="NOME" class="inputEmail" required>
                        <input type="password" name="senha" placeholder="SENHA" class="inputSenha" required>
                        <input type="email" name="email" placeholder="EMAIL" class="inputEmail" required>
                        <input type="password" name="confirma_senha" placeholder="CONFIRME A SENHA" class="inputSenha" required>
                        <input type="text" name="telefone" placeholder="TELEFONE" class="inputTelefone" required>
                        <input type="text" name="cep" placeholder="CEP" class="inputGps" required>
                        <input type="text" name="endereco" placeholder="ENDEREÇO" class="inputGps" required>
                        <input type="text" name="complemento" placeholder="COMPLEMENTO" class="inputGps">
                        <input type="text" name="cidade" placeholder="CIDADE" class="inputGps" required>
                        <input type="text" name="estado" placeholder="ESTADO" class="inputGps" id="estadoInput" required>
                    </div>
                    <div class="cadastrarUser">
                        <button id="cadastrarUser" type="submit">CADASTRAR</button>
                    </div>
                </form>
                <div class="voltarLogin">
                    <span><a href="#" onclick="window.open('../pages/perfilUsuario.php', '_self')">Voltar ao   
                            login</a></span>
                </div>
            </div>
        </div>

    </main>


    <script src="../scripts/navbar.js"></script>
    <script src="../scripts/loading.js"></script>
    <script src="../scripts/trocaLogin.js"></script>
</body>

</html>