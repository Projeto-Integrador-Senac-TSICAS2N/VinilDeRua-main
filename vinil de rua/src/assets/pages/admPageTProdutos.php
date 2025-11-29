<?php
require_once __DIR__ . "/../scripts/protecaoLogin.php";
require_once __DIR__ . "/../scripts/conexao.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos - Vinil de Rua</title>

    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../styles/styleAdm.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        #graficoWrapper {
            width: 100%;
            height: 280px;
        }

        .cardProduto {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
        }

        .cardProduto img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>
</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="">
    </div>

    <div class="painelAdmin">

        <aside class="menuLateral">
            <div class="areaLogo">
                <a href="/VinilDeRua-main/vinil de rua/index.php">
                    <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png" alt="Logo Vinil de Rua">
                </a>
                <h1>Vinil de Rua</h1>
            </div>

            <nav class="menuPrincipal">
                <button class="itemMenuAtivo" onclick="window.open('../pages/admPageTProdutos.php' , '_self')">Todos os produtos</button>
                <button class="itemMenu" onclick="window.open('../pages/admPageDashboard.php', '_self')">Dashboard</button>
                <button class="itemMenu" onclick="window.open('../pages/admPageAddP.php' , '_self')">Adicionar Produto</button>
                <button class="itemMenu" onclick="window.open('../pages/admPageRemoveP.php' , '_self')">Deletar Produto</button>
                <button class="itemMenu" onclick="window.open('../pages/admPageNotificacao.php' , '_self')">Notificações</button>
            </nav>

            <div class="menuCategorias">
                <h1 style="font-family:'Young Serif'; font-size:20px; margin-bottom:10px;">Categorias</h1>
                <ul style="list-style:none; padding:0;">
                    <?php
                    $sql = "SELECT genero, COUNT(*) AS total 
                FROM produtos 
                WHERE genero NOT LIKE '%USB%'
                AND genero NOT LIKE '%Bluetooth%'
                AND genero NOT LIKE '%Vitrola%'
                AND genero NOT LIKE '%Turntable%'
                AND genero IS NOT NULL
                AND genero <> ''
                GROUP BY genero 
                ORDER BY genero ASC";

                    $stmt = $con->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()):
                    ?>
                        <li onclick="filtrarCategoria('<?php echo $row['genero']; ?>', this)"
                            style="display:flex; justify-content:space-between; cursor:pointer;
                            padding:4px 2px; font-family:'Young Serif'; font-size:15px; transition:0.2s;">
                            <span><?php echo $row['genero']; ?></span>
                            <span><?php echo $row['total']; ?></span>
                        </li>
                    <?php 
                    endwhile; 
                    ?>
                </ul>
            </div>


        </aside>

        <main class="conteudoPrincipal" style="font-family: Arial, Helvetica, sans-serif;">

            <h2 style="font-family: Anton;">Todos os produtos</h2>

            <!-- DASHBOARD -->
            <section style="display:flex; gap:30px;">

                <!-- GRÁFICO -->
                <div style="flex:3; background:white; padding:20px; border-radius:10px;">
                    <h3>Distribuição de estoque</h3>
                    <div id="graficoWrapper">
                        <canvas id="graficoEstoque"></canvas>
                    </div>
                </div>

                <!-- FILTROS -->
                <div style="flex:1;">
                    <div style="background:white; padding:15px; border-radius:10px;">
                        <h4>Pesquisa de discos</h4>
                        <input id="campoBusca" type="text" class="input" placeholder="Nome, autor, ID...">
                        <button onclick="buscar()" class="btn">Pesquisar</button>
                    </div>

                    <div style="background:white; padding:15px; margin-top:15px; border-radius:10px;">
                        <h4>Filtro de discos</h4>

                        <label>Categoria</label>
                        <select id="filtroCategoria">
                            <option value="todas">Todas</option>
                            <option>Grime</option>
                            <option>Drill</option>
                            <option>R&B</option>
                            <option>90’s - Y2K</option>
                            <option>Boombap</option>
                        </select>
                        <br>
                        <label>Situação</label>
                        <select id="filtroStatus">
                            <option value="qualquer">Qualquer</option>
                            <option value="estoque">Com estoque</option>
                            <option value="zerado">Sem estoque</option>
                        </select>
                        <br>
                        <button onclick="filtrar()" class="btn">Aplicar filtros</button>
                    </div>
                </div>
            </section>


            <!-- RESULTADOS -->
            <section style="margin-top:30px;">
                <h3>Discos correspondentes</h3>
                <div id="listaProdutos"></div>
            </section>

        </main>
    </div>

    <script>
        // ------- Buscar Produtos ------
        function buscar() {
            const termo = document.getElementById("campoBusca").value;
            carregarProdutos(`buscar=${termo}`);
        }

        // ------- Filtrar ------
        function filtrar() {
            const cat = document.getElementById("filtroCategoria").value;
            const status = document.getElementById("filtroStatus").value;
            carregarProdutos(`categoria=${cat}&status=${status}`);
        }

        // ------- AJAX ------
        function carregarProdutos(parametros = "") {
            fetch(`../scripts/buscarProdutos.php?${parametros}`)
                .then(r => r.text())
                .then(html => document.getElementById("listaProdutos").innerHTML = html);
        }

        // Carrega ao abrir
        carregarProdutos();

        // ------- Gráfico estoque ------
        fetch("../scripts/getEstoqueDistribuicao.php")
            .then(r => r.json())
            .then(dados => {
                new Chart(document.getElementById("graficoEstoque"), {
                    type: 'pie',
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    },
                    data: {
                        labels: dados.labels,
                        datasets: [{
                            data: dados.valores,
                            backgroundColor: ["#111", "#333", "#666", "#999", "#BBB", "#000"]
                        }]
                    }
                });
            });
    </script>

    <script src="../scripts/loading.js"></script>
</body>

</html>