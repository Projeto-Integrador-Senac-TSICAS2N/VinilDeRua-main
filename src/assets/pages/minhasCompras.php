<?php
require_once "../scripts/conexao.php";
require_once "../scripts/protecaoLogin.php";
$usuario_id = $_SESSION['usuario_id'];

// --- BUSCAR TODOS OS PEDIDOS DO USUÁRIO ---
$sqlPedidos = mysqli_query($con, "
    SELECT 
        p.id AS pedido_id,
        p.data_pedido,
        p.valor_total,
        pi.produto_id,
        pi.quantidade,
        pr.nome AS produto_nome,
        pr.img_link
    FROM pedidos p
    JOIN pedido_itens pi ON p.id = pi.pedido_id
    JOIN produtos pr ON pr.id = pi.produto_id
    WHERE p.usuario_id = $usuario_id
    ORDER BY p.data_pedido DESC
");
$sqlUser = mysqli_query($con, "
    SELECT nome, email
    FROM usuarios 
    WHERE id = $usuario_id
    LIMIT 1
");
$user = mysqli_fetch_assoc($sqlUser);
$nome = $user['nome'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Compras - Perfil</title>
    <!-- FONTES USADASS -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    <link rel="stylesheet" href="/VinilDeRua-main/vinil de rua/src/assets/styles/perfil.css">
    <link rel="shortcut icon" type="imagex/png" href="/VinilDeRua-main/vinil de rua/src/assets/images/logoVinilDeRua.svg">

</head>

<body>

    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading" border="0">
    </div>

    <header>
        <div class="logoHeader">
            <a href="/VinilDeRua-main/vinil de rua/index.php"><img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png"
                    alt="logo-Vinil-De-Rua" border="0"></a>
            <p>VINIL <br>DE RUA</p>
        </div>
        <nav>
            <a href="/index.html#catalogo">Cátalogo</a>
            <a href="/src/assets/pages/pageOff.html#catalogoOff">Ofertas</a>
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
    </header>


    <section class="fundoPrincipal">
        <main>

            <div class="saudacaoUser">
                <h1>Olá, <?= htmlspecialchars($nome) ?></h1>
            </div>
            <hr>

            <div class="secoesUser">
                <a href="/src/assets/pages/infoUser.html">Informações Pessoais</a>
                <a href="/src/assets/pages/carrinho.html">Carrinho</a>
                <a href="/src/assets/pages/favorito.html">Favoritos</a>
                <a href="/src/assets/pages/minhasCompras.html">Minhas Compras</a>
            </div>

            <div class="tituloPag">
                <h1>Minhas Compras</h1>
            </div>

            <div class="itensCarrinho">

                <?php if (mysqli_num_rows($sqlPedidos) === 0): ?>

                    <p style="text-align:center; font-size:22px; margin-top:40px;">
                        Você ainda não fez nenhuma compra.
                    </p>

                <?php else: ?>

                    <?php while ($p = mysqli_fetch_assoc($sqlPedidos)): ?>

                        <div class="itemCar">

                            <!-- capa do vinil -->
                            <img src="<?= $p['img_link'] ?>" class="imgCar">

                            <div class="infoCarrinho">

                                <!-- Resumo -->
                                <div class="info">
                                    <h1>Resumo</h1>
                                    <p><?= htmlspecialchars($p['produto_nome']) ?></p>
                                    <p>ID: <?= $p['produto_id'] ?></p>
                                </div>

                                <!-- Quantidade -->
                                <div class="info">
                                    <h1>Quantidade</h1>
                                    <p><?= $p['quantidade'] ?></p>
                                </div>

                                <!-- Data -->
                                <div class="infoPreco">
                                    <h1>Data</h1>
                                    <p>
                                        <?= date("d/m/Y", strtotime($p['data_pedido'])) ?>
                                    </p>
                                </div>

                                <!-- Preço final -->
                                <div class="infoPrecoF">
                                    <h1>Preço final</h1>
                                    <p>R$<?= number_format($p['valor_total'], 2, ',', '.') ?></p>
                                </div>

                            </div>
                        </div>

                    <?php endwhile; ?>

                <?php endif; ?>

            </div>

        </main>

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
                <a id="openTerms" style="cursor: pointer;">Termos e Condições</a>
            </div>
        </footer>
        <div id="popupOverlay" aria-hidden="true">
            <div id="popupBox" role="dialog" aria-modal="true" aria-labelledby="popupTitle">
                <button id="closePopup" aria-label="Fechar popup">&times;</button>
                <div class="popupContent">
                    <h2 id="popupTitle">Termos e Condições</h2>
                    <p># **Termos e Condições de Uso – Vinil de Rua**

                        **Última atualização: 21 de novembro de 2025**

                        Site oficial: [**https://vinilderua.com**](https://vinilderua.com/)

                        ---

                        ## **1. Sobre o Vinil de Rua**

                        O Vinil de Rua é um **e-commerce especializado em discos de vinil, vitrolas e conhecimentos
                        musicais**.

                        Todas as vendas realizadas no site são feitas **diretamente pelo Vinil de Rua**, não havendo
                        intermediação de terceiros ou ambiente de marketplace.

                        ---

                        ## **2. Aceitação dos Termos**

                        Ao acessar ou comprar no Vinil de Rua, você concorda com:

                        - Estes Termos e Condições
                        - Nossa Política de Privacidade
                        - Nossas políticas de pagamento, entrega e trocas/devoluções

                        Caso não concorde, não utilize o site.

                        Podemos atualizar estes Termos periodicamente, sempre mantendo a versão mais recente em
                        **vinilderua.com/termos**.

                        ---

                        ## **3. Uso do Site**

                        O usuário se compromete a:

                        - Não utilizar o site para fins ilegais
                        - Não tentar acessar partes restritas ou sistemas internos
                        - Não tentar interferir no funcionamento do site
                        - Não reproduzir, copiar ou explorar conteúdo sem autorização

                        ---

                        ## **4. Cadastro e Conta**

                        O cadastro é opcional, mas facilita o acompanhamento de pedidos.

                        Ao se cadastrar, o usuário declara que:

                        - Forneceu informações reais e atualizadas
                        - É responsável pela segurança da senha
                        - Não compartilhará seus dados de acesso

                        Contas podem ser suspensas em caso de uso fraudulento, tentativa de golpe ou descumprimento
                        destes Termos.

                        ---</p>
                    <p>## **5. Produtos e Estoque**

                        Trabalhamos com:

                        - Novos e usados (quando aplicável)
                        - Produtos com descrição, fotos e informações reais

                        O Vinil de Rua se compromete a:

                        - Manter informações atualizadas
                        - Informar claramente quando um produto é usado
                        - Descrever estado, prensagem ou edição da melhor forma possível

                        Como trabalhamos com itens muitas vezes únicos, especialmente usados, o produto pode se esgotar
                        rapidamente. A compra só é confirmada após o pagamento aprovado.

                        ---

                        ## **6. Preços e Pagamentos**

                        Os preços exibidos no site:

                        - Estão em reais (BRL)
                        - Podem ser alterados sem aviso prévio
                        - Podem conter promoções ou cupons por tempo limitado

                        Aceitamos pagamentos por:

                        - Cartão de crédito
                        - Pix
                        - Boleto bancário (se ativado)
                        - Outras soluções de pagamento exibidas no checkout

                        Pagamentos são processados por plataformas externas (como Mercado Pago, Stripe, PagSeguro etc.).
                        Essas plataformas podem ter seus próprios termos e políticas.

                        ---

                        ## **7. Envio, Prazos e Entregas**

                        Os envios são realizados por:

                        - Correios
                        - Transportadoras parceiras (quando aplicável)

                        O prazo de entrega exibido no site é estimado.

                        Após o envio, o usuário recebe o código de rastreamento.

                        Não nos responsabilizamos por atrasos causados por:

                        - Greves
                        - Problemas nos Correios
                        - Eventos climáticos
                        - Dificuldades de entrega no endereço fornecido

                        Caso o pedido retorne por **endereço incorreto ou ausência do destinatário**, poderá haver
                        cobrança de novo frete para reenvio.

                        ---

                        ## **8. Trocas e Devoluções**

                        O usuário tem direito a solicitar:

                        ### **Devolução (arrependimento) – 7 dias corridos**

                        Conforme o Código de Defesa do Consumidor.

                        ### **Troca por defeito – 30 dias**

                        Se o disco, CD ou item apresentar defeito não informado.

                        Itens devem ser enviados:

                        - Na embalagem original
                        - Sem sinais de mau uso
                        - Com todos os acessórios (se aplicável)

                        Não aceitamos devolução de:

                        - Discos usados cuja condição já foi claramente descrita
                        - Produtos danificados por mau uso
                        - Itens lacrados que foram abertos, salvo defeito

                        ---

                        ## **9. Limitação de Responsabilidade**

                        O Vinil de Rua não se responsabiliza por:

                        - Uso incorreto dos produtos
                        - Perdas causadas por terceiros (ex: transportadora)
                        - Informações inseridas incorretamente pelo cliente no cadastro ou no endereço
                        - Atrasos ou erros decorrentes de serviços externos (pagamentos, logística, etc.)

                        ---

                        ## **10. Propriedade Intelectual**

                        Todo o conteúdo de **vinilderua.com** — textos, fotos, vídeos, logotipo, layout, código e
                        descrições — é protegido por direitos autorais.

                        É proibido:

                        - Copiar conteúdos
                        - Reproduzir fotos ou descrições
                        - Usar a marca Vinil de Rua sem autorização

                        ---

                        ## **11. Privacidade e Segurança**

                        Tratamos dados pessoais conforme nossa **Política de Privacidade**, disponível em:

                        ➡️ **vinilderua.com/privacidade**

                        Coletamos apenas o necessário para processar pedidos, proporcionar uma boa experiência de
                        navegação e cumprir obrigações legais.

                        ---

                        ## **12. Cancelamentos de Pedidos**

                        O Vinil de Rua pode cancelar pedidos em caso de:

                        - Falta de estoque
                        - Erro de preço evidente
                        - Suspeita de fraude
                        - Pagamento não aprovado

                        Em cenários de cancelamento por parte da loja, o cliente será integralmente reembolsado.

                        ---

                        ## **13. Foro e Lei Aplicável**

                        Este documento é regido pelas leis brasileiras.

                        Disputas serão resolvidas no **Foro da Comarca de São Paulo – SP**, salvo quando o consumidor
                        optar pelo foro de seu domicílio, conforme o CDC.</p>
                </div>
            </div>
        </div>

    </section>

    <script src="/VinilDeRua-main/vinil de rua/src/assets/scripts/navbar.js"></script>
    <script src="/VinilDeRua-main/vinil de rua/src/assets/scripts/loading.js"></script>
    <script src="/VinilDeRua-main/vinil de rua/src/assets/scripts/popup.js"></script>
    <script src="/VinilDeRua-main/vinil%20de%20rua/src/assets/scripts/profileScript.js"></script>

</body>

</html>