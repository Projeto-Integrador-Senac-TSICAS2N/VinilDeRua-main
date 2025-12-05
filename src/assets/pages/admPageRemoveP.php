<?php
require_once "../scripts/conexao.php"; // conexão com banco
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM Page - Remover Produto</title>
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/styleAdm.css">
</head>

<body>

    <div class="painelAdmin">

        <!-- MENU LATERAL -->
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

        <!-- CONTEÚDO PRINCIPAL -->
        <main class="conteudoPrincipal">

            <header class="menuSuperior">
                <div class="campoBusca">
                    <input type="text" placeholder="Buscar produto...">
                    <button>Buscar</button>
                </div>
            </header>

            <section class="secaoProdutos">
                <h2 class="tituloSecao">Todos os produtos</h2>

                <div class="gradeProdutos">

                    <?php
                    $query = "SELECT id, nome, preco, estoque, img_link FROM produtos ORDER BY id DESC";
                    $resultado = mysqli_query($con, $query);

                    if (mysqli_num_rows($resultado) > 0) {
                        while ($row = mysqli_fetch_assoc($resultado)) {
                            echo "
                        <div class='cardProduto'>
                            <img src='{$row['img_link']}' alt='{$row['nome']}'>
                            <div class='infosProduto'>
                                <h1>{$row['nome']}</h1>
                                <p>R$ {$row['preco']}</p>
                                <p>Estoque: {$row['estoque']}</p>
                                <p>ID: {$row['id']}</p>

                                <button class='btnRemove' onclick='confirmarExclusao({$row['id']})'>Excluir</button>
                            </div>
                        </div>
                        ";
                        }
                    } else {
                        echo "<p style='color:white;'>Nenhum produto encontrado.</p>";
                    }
                    ?>
                </div>
            </section>

        </main>
    </div>

    <script>
        function confirmarExclusao(id) {
            if (confirm("Tem certeza que deseja excluir este produto? Essa ação não pode ser desfeita!")) {
                window.location.href = "../scripts/removerProduto.php?id=" + id;
            }
        }
    </script>

</body>

</html>