<?php
require_once __DIR__ . "/../scripts/protecaoLogin.php";
require_once __DIR__ . "/../scripts/conexao.php";

/* ---------------------- RESUMO PRINCIPAL ---------------------- */

// Usuários cadastrados
$totalUsuarios = $con->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc()['total'] ?? 0;

// Produtos ativos
$totalProdutos = $con->query("SELECT COUNT(*) AS total FROM produtos")->fetch_assoc()['total'] ?? 0;

// Total pedidos
$totalPedidos = $con->query("SELECT COUNT(*) AS total FROM pedidos")->fetch_assoc()['total'] ?? 0;

// Estoque baixo (<=3)
$estoqueBaixo = $con->query("SELECT COUNT(*) AS total FROM produtos WHERE estoque <= 3")->fetch_assoc()['total'] ?? 0;


/* ---------------------- GRÁFICO PEDIDOS POR MÊS ---------------------- */

$labelsMes = [];
$valoresMes = [];

$sqlPedidosMes = "
    SELECT 
        DATE_FORMAT(data_pedido, '%m/%Y') AS mes_legenda,
        DATE_FORMAT(data_pedido, '%Y-%m') AS mes_ordenacao,
        COUNT(*) AS total
    FROM pedidos
    GROUP BY mes_ordenacao, mes_legenda
    ORDER BY mes_ordenacao DESC
    LIMIT 6
";

$result = $con->query($sqlPedidosMes);

while ($row = $result->fetch_assoc()) {
    $labelsMes[]  = $row['mes_legenda'];
    $valoresMes[] = (int) $row['total'];
}

$labelsMes  = array_reverse($labelsMes);
$valoresMes = array_reverse($valoresMes);


/* ---------------------- ÚLTIMAS AÇÕES ---------------------- */

// Últimos pedidos
$ultimosPedidos = [];
$res = $con->query("
    SELECT id, data_pedido, valor_total
    FROM pedidos
    ORDER BY data_pedido DESC
    LIMIT 5
");
while ($row = $res->fetch_assoc()) $ultimosPedidos[] = $row;

// Últimos produtos
$ultimosProdutos = [];
$res = $con->query("
    SELECT nome, data_introducao, estoque
    FROM produtos
    ORDER BY data_introducao DESC
    LIMIT 5
");
while ($row = $res->fetch_assoc()) $ultimosProdutos[] = $row;

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo - Vinil de Rua</title>

    <!-- FONTES -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../styles/styleAdm.css">
    <link rel="shortcut icon" type="image/png" href="../images/logoVinilDeRua.svg">
</head>

<body>

<div id="preloader">
    <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
</div>

<div class="painelAdmin">

    <!-- -------- MENU LATERAL -------- -->
    <aside class="menuLateral">
        <div class="areaLogo">
            <a href="/VinilDeRua-main/vinil de rua/index.php">
                <img src="https://i.ibb.co/RknvXKX2/logo-Vinil-De-Rua-preta.png">
            </a>
            <h1>Vinil de Rua</h1>
        </div>

        <nav class="menuPrincipal">
            <button onclick="location.href='admPageTProdutos.php'">Todos os produtos</button>
            <button class="itemMenuAtivo">Dashboard</button>
            <button onclick="location.href='admPageAddP.php'">Adicionar Produto</button>
            <button onclick="location.href='admPageRemoveP.php'">Deletar Produto</button>
            <button onclick="location.href='admPageNotificacao.php'">Notificações</button>
        </nav>
    </aside>


    <!-- -------- CONTEÚDO PRINCIPAL -------- -->
    <main class="conteudoPrincipal" style="font-family: Arial, Helvetica, sans-serif;">

        <header class="menuSuperior">
            <div class="campoBusca">
                <input type="text" placeholder="Buscar produto...">
                <button>Buscar</button>
            </div>
        </header>

        <section class="secaoDashboard">
            <h2>Dashboard Administrativo</h2>
            
            <!-- CARDS -->
            <div class="cards-resumo">
                <div class="cardResumo">
                    <span>Usuários cadastrados</span>
                    <strong><?= $totalUsuarios ?></strong>
                </div>

                <div class="cardResumo">
                    <span>Produtos ativos</span>
                    <strong><?= $totalProdutos ?></strong>
                </div>

                <div class="cardResumo">
                    <span>Pedidos</span>
                    <strong><?= $totalPedidos ?></strong>
                </div>

                <div class="cardResumo cardAlerta">
                    <span>Estoque baixo (≤ 3)</span>
                    <strong><?= $estoqueBaixo ?></strong>
                </div>
            </div>


            <!-- GRID -->
            <div class="dashboard-grid">

                <!-- GRÁFICO -->
                <div class="cardDashboard">
                    <h3>Pedidos por mês</h3>
                    <canvas id="graficoPedidos"></canvas>
                </div>

                <!-- ÚLTIMAS AÇÕES -->
                <div class="cardDashboard">
                    <h3>Últimas ações</h3>

                    <h4>Últimos pedidos</h4>
                    <ul>
                        <?php if (!$ultimosPedidos): ?>
                            <li>Sem pedidos registrados.</li>
                            <br>
                        <?php else: foreach ($ultimosPedidos as $p): ?>
                            <li>
                                Pedido #<?= $p['id'] ?> - 
                                <?= date("d/m/Y H:i", strtotime($p['data_pedido'])) ?> -
                                R$ <?= number_format($p['valor_total'], 2, ',', '.') ?>
                            </li>
                        <?php endforeach; endif; ?>
                    </ul>

                    <h4>Últimos produtos cadastrados</h4>
                    <ul>
                        <?php if (!$ultimosProdutos): ?>
                            <li>Nenhum produto cadastrado.</li>
                        <?php else: foreach ($ultimosProdutos as $prod): ?>
                            <li><?= $prod['nome'] ?> — estoque <?= $prod['estoque'] ?></li>
                        <?php endforeach; endif; ?>
                    </ul>
                </div>

            </div>
        </section>
    </main>
</div>

<!-- ---------- SCRIPTS ---------- -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../scripts/loading.js"></script>

<script>
// Dados enviados do PHP
const labels = <?= json_encode($labelsMes) ?>;
const valores = <?= json_encode($valoresMes) ?>;

new Chart(document.getElementById('graficoPedidos'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Pedidos por mês',
            data: valores,
            backgroundColor: 'rgba(0,0,0,0.7)',
            borderColor: 'black',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

</body>
</html>
