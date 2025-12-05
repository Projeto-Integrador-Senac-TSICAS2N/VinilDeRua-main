<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM Page</title>
    <!-- FONTES USADASS -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    <link rel="stylesheet" href="../styles/styleAdm.css">
    <link rel="shortcut icon" type="imagex/png" href="../images/logoVinilDeRua.svg">
</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading" border="0">
    </div>

    <div class="painelAdmin">

        <!-- MENU LATERAL -->
        <aside class="menuLateral">
            <div class="areaLogo">
                <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                <h1>Vinil de Rua</h1>
            </div>

            <nav class="menuPrincipal">
                <button class="itemMenu" onclick="window.open('../pages/admPageTProdutos.php' , '_self')">Todos os produtos</button>
                <button class="itemMenu" onclick="window.open('../pages/admPageDashboard.php', '_self')">Dashboard</button>
                <button class="itemMenuAtivo" onclick="window.open('../pages/admPageAddP.php' , '_self')">Adicionar Produto</button>
                <button class="itemMenu" onclick="window.open('../pages/admPageRemoveP.php' , '_self')">Deletar Produto</button>
                <button class="itemMenu" onclick="window.open('../pages/admPageNotificacao.php' , '_self')">Notificações</button>
            </nav>

            <div class="menuCategorias">
                <h1>Categorias</h1>
                <ul>
                    <li><span>Grime</span><span>8</span></li>
                    <li><span>Drill</span><span>8</span></li>
                    <li><span>R&B</span><span>8</span></li>
                    <li><span>90’s - Y2K</span><span>8</span></li>
                    <li><span>Boombap</span><span>8</span></li>
                </ul>
            </div>
        </aside>

        <!-- CONTEÚDO PRINCIPAL -->
        <main class="conteudoPrincipal">

            <!-- MENU SUPERIOR -->
            <header class="menuSuperior">
                <div class="campoBusca">
                    <input type="text" placeholder="Buscar produto...">
                    <div class="btnBusca">
                        <button>Buscar</button>
                    </div>
                </div>

                <div class="areaUsuario">
                    <i class="icon-user">
                        <img src="https://i.ibb.co/v6qZmTGv/perfil-Icon.png" alt="">
                    </i>
                </div>
            </header>

            <!-- SEÇÃO DE PRODUTOS  -->
            <section class="secaoProdutos">
                <h1 class="tituloSecao">Adicione o seu produto!</h1>

                <div class="formsEAddFoto">

                    <div class="formsNovoProduto">

                        <form action="../scripts/addProduto.php" method="POST">

                            <div class="infoForms">
                                <label>Nome do produto:</label>
                                <input type="text" name="nome" placeholder="Nome..." required>
                            </div>

                            <div class="infoForms">
                                <label>Nome do(a) artista:</label>
                                <input type="text" name="autor" placeholder="Nome..." required>
                            </div>

                            <div class="infoForms">
                                <label>Preço:</label>
                                <input type="number" step="0.01" name="preco" placeholder="Preço..." required>
                            </div>

                            <div class="infoForms">
                                <label>Quantidade (Estoque):</label>
                                <input type="number" name="estoque" placeholder="Quantidade..." required>
                            </div>

                            <div class="infoForms">
                                <label>Gênero Musical/Tecnologia:</label>
                                <input type="text" name="genero" placeholder="Gênero/Tecnologia..." required>
                            </div>

                            <div class="infoForms">
                                <label>Link da Imagem do Álbum:</label>
                                <input type="text" name="img_link" placeholder="Link da imagem do álbum..." required>
                            </div>

                            <div class="LPorVit">
                                <label for="vitOrLP">Selecione o tipo de produto:</label>
                                <select id="vitOrLP" name="categoria" required>
                                    <option value="" hidden>Selecione</option>
                                    <option value="1">Vitrola</option>
                                    <option value="0">Vinil</option>
                                </select>

                            </div>

                            <div class="btnAdicionarP">
                                <button type="submit">Adicionar Produto</button>
                            </div>

                        </form>

                    </div>
                </div>

            </section>
        </main>
    </div>
    <script src="../scripts/loading.js"></script>
    <script src="../scripts/addImag.js"></script>
</body>

</html> 