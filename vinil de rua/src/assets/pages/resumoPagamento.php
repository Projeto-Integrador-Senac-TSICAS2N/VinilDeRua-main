<?php
require_once "../scripts/conexao.php";
require_once "../scripts/protecaoLogin.php";

// ---------- IMPEDIR ACESSO SEM CARRINHO ----------
if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
    echo "<script>alert('Seu carrinho está vazio!'); window.location='../pages/carrinho.php';</script>";
    exit;
}
$usuario_id = $_SESSION['usuario_id'];
// ---------- BUSCAR DADOS DO USUÁRIO ----------
$sqlUser = "SELECT nome, email FROM usuarios WHERE id = $usuario_id";
$user = mysqli_fetch_assoc(mysqli_query($con, $sqlUser));

// ---------- BUSCAR ENDEREÇO ----------
$sqlEndereco = "SELECT * FROM enderecos WHERE usuario_id = $usuario_id LIMIT 1";
$endereco = mysqli_fetch_assoc(mysqli_query($con, $sqlEndereco));

// ---------- BUSCAR TELEFONE ----------
$sqlTel = "SELECT numero_usuario FROM telefones WHERE usuario_id = $usuario_id LIMIT 1";
$telefone = mysqli_fetch_assoc(mysqli_query($con, $sqlTel));
$telefone = $telefone ? $telefone['numero_usuario'] : "Não informado";

// ---------- BUSCAR ITENS DO CARRINHO ----------
$produtos = [];
$totalProdutos = 0;

foreach ($_SESSION['carrinho'] as $id => $qtd) {
    $sql = "SELECT id, nome, preco, img_link FROM produtos WHERE id = $id LIMIT 1";
    $res = mysqli_query($con, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $p = mysqli_fetch_assoc($res);
        $p['quantidade'] = is_array($qtd) ? intval($qtd['quantidade'] ?? 1) : intval($qtd);
        $p['subtotal'] = floatval($p['preco']) * intval($qtd);
        $totalProdutos += $p['subtotal'];
        $produtos[] = $p;
    }
}

// Taxa fixa fictícia
$valorEntrega = 10.00;
$totalGeral = $totalProdutos + $valorEntrega;
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo da compra</title>
    <!-- FONTES USADASS -->
    <link href="https://fonts.googleapis.com/css2?family=Caesar+Dressing&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <!-- SEPARAÇÃO -->
    <link rel="stylesheet" href="../styles/resumoCompra.css">
    <link rel="stylesheet" href="../styles/cartao.css">
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
            <p>VINIL <br>DE RUA</p>
        </div>
        <nav>
            <a href="/VinilDeRua-main/vinil de rua/index.php#catalogo">Cátalogo</a>
            <a href="/VinilDeRua-main/vinil de rua/index.php">Ofertas</a>
            <a href="/VinilDeRua-main/vinil de rua/index.php">Contato</a>
        </nav>
        <div class="icons">
            <a href="../pages/favorito.php"><img src="https://i.ibb.co/ynVyBhq2/favorite.png"
                    alt="favorite"></a>
            <a href="../pages/carrinho.php"><img src="https://i.ibb.co/JRf4dtY8/shopping-cart.png"
                    alt="shopping-cart"></a>
            <a href="../pages/perfilUsuario.php"><img src="https://i.ibb.co/4RGqW28z/account-circle.png"
                    alt="account-circle"></a>
        </div>
    </header>


    <section class="fundoPrincipal">

        <div class="infoSituation">
            <div class="produtoSituation">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="logo Vinil De Rua">
                <p>Produtos</p>
            </div>
            <div class="indentificacaoSituation">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="logo Vinil De Rua">
                <p>Indentificação</p>
            </div>
            <div class="pagamentoSituation">
                <img src="https://i.ibb.co/zhNXFH1t/logo-Vinil-De-Rua-branca.png" alt="logo Vinil De Rua">
                <p>Pagamento</p>
            </div>
        </div>



        <section class="resumoCompra">

            <div class="txtResumo">
                <h1>Resumo da compra:</h1>
            </div>

            <section class="cardsInfos">
                <div class="cardResumo">
                    <div class="tituloEditar">
                        <h1>Contato:</h1>
                        <a href="../pages/perfilUsuario.php">Editar</a>
                    </div>
                    <p><?= htmlspecialchars($user['email']) ?></p>
                </div>

                <div class="cardResumo">
                    <div class="tituloEditar">
                        <h1>Endereço:</h1>
                        <a href="../pages/perfilUsuario.php">Editar</a>
                    </div>
                    <p><?= $user['nome'] ?></p>
                    <p><?= $endereco['Logradouro'] ?></p>
                    <p><?= $endereco['CEP'] ?></p>
                    <p><?= $endereco['Cidade'] ?> - <?= $endereco['Estado'] ?></p>
                    <p><?= $endereco['complemento'] ?: 'Sem complemento' ?></p>
                    <p><?= $telefone ?></p>
                </div>

                <div class="cardResumo">
                    <div class="tituloEditar">
                        <h1>Opções de entrega:</h1>
                        <a href="">Editar</a>
                    </div>
                    <p>Entrega agendada</p>
                    <p><?= date('d/m/Y', strtotime('+2 days')) ?> — 10:00 às 12:40</p>
                    <p>R$<?= number_format($valorEntrega, 2, ',', '.') ?></p>
                </div>

            </section>

            <div class="pedidoFinal">

                <div class="cardResumo">
                    <div class="tituloEditar">
                        <h1>Seu pedido</h1>
                        <a href="../pages/carrinho.php">Editar</a>
                    </div>

                    <div class="produtosFinais">

                        <?php foreach ($produtos as $item): ?>

                            <?php
                            // 🔥 corrigir categoria
                            $categoriaTexto = ($item["categoria"] ?? 0) == 0 ? "Vinil" : "Vitrola";
                            ?>

                            <div class="produtoItem">
                                <img src="<?= $item['img_link'] ?>" style="width:330px; height:330px; object-fit:cover; border-radius:10px;">
                                <div class="infosFinais">
                                    <h1><?= $item['nome'] ?></h1>
                                    <p><strong>Categoria:</strong> <?= $categoriaTexto ?></p>
                                    <p><strong>Preço unitário:</strong> R$<?= number_format($item['preco'], 2, ',', '.') ?></p>
                                    <p><strong>Quantidade:</strong> <?= $item['quantidade'] ?></p>
                                    <p><strong>Subtotal:</strong> R$<?= number_format($item['subtotal'], 2, ',', '.') ?></p>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>

                    <div class="infosPessoaisCompra">
                        <p>Produtos: <?= count($produtos) ?> - R$<?= number_format($totalProdutos, 2, ',', '.') ?></p>
                        <p>Entrega: R$<?= number_format($valorEntrega, 2, ',', '.') ?></p>
                        <p><strong>Total: R$<?= number_format($totalGeral, 2, ',', '.') ?></strong></p>
                    </div>
                </div>
            </div>

            </div>
            <form method="POST" action="../scripts/simulacaoPagamento.php" id="formPagamento">

                <!-- total enviado para o pagamento -->
                <input type="hidden" name="total" value="<?= $totalGeral ?>">

                <!-- método de pagamento real enviado pelo JS -->
                <input type="hidden" name="payMethod" id="inputPayMethod">

                <div class="fazerPagamento">
                    <div class="formasPagamento">
                        <h1>Selecione uma forma de pagamento:</h1>

                        <div class="cardResumo">
                            <label class="circleCheckbox">
                                <input type="checkbox" class="payOption" data-method="PIX">
                                <span></span>
                                <img src="https://i.ibb.co/WpgW73SM/pixPay.png" alt="pixPay">
                                <p>PIX</p>
                            </label>
                        </div>

                        <div class="cardResumo">
                            <label class="circleCheckbox" required>
                                <input type="checkbox" class="payOption" data-method="Cartão">
                                <span></span>
                                <img src="https://i.ibb.co/Jw4Fw4Q4/mastercard-Pay.png">
                                <p>Débito/Crédito</p>
                            </label>
                        </div>

                        <div class="cardResumo">
                            <label class="circleCheckbox" required>
                                <input type="checkbox" class="payOption" data-method="Boleto">
                                <span></span>
                                <img src="https://i.ibb.co/5hGCS8jn/boleto-Pay.png">
                                <p>Boleto</p>
                            </label>
                        </div>

                        <div class="cardResumo cardFiado" required>
                            <label class="circleCheckbox">
                                <input type="checkbox" class="payOption" data-method="Fiado">
                                <span></span>
                                <img src="https://i.ibb.co/Zpx1P4rS/fiadoPay.png">
                                <p>Fiado</p>
                            </label>
                        </div>
                    </div>
                    <div id="areaPix" style="display:none; text-align:center;">
                        <h3>PIX</h3>

                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=Vinil%20De%20Rua%20Pagamento"
                            alt="QR Code PIX" class="qrPix">

                        <p class="chavePix">Chave PIX: contato@vinilderua.com.br</p>
                    </div>


                    <section class="sectionCard" style="display: none;" id="areaCartao">
                        <div class="container preload">
                            <div class="creditcard">
                                <div class="front">
                                    <div id="ccsingle"></div>
                                    <svg version="1.1" id="cardfront" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 750 471"
                                        style="enable-background:new 0 0 750 471;" xml:space="preserve">
                                        <g id="Front">
                                            <g id="CardBackground">
                                                <g id="Page-1_1_">
                                                    <g id="amex_1_">
                                                        <path id="Rectangle-1_1_" class="lightcolor grey" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                            C0,17.9,17.9,0,40,0z" />
                                                    </g>
                                                </g>
                                                <path class="darkcolor greydark"
                                                    d="M750,431V193.2c-217.6-57.5-556.4-13.5-750,24.9V431c0,22.1,17.9,40,40,40h670C732.1,471,750,453.1,750,431z" />
                                            </g>
                                            <text transform="matrix(1 0 0 1 60.106 295.0121)" id="svgnumber"
                                                class="st2 st3 st4">0123
                                                4567
                                                8910 1112</text>
                                            <text transform="matrix(1 0 0 1 54.1064 428.1723)" id="svgname"
                                                class="st2 st5 st6">Lázaro Barbosa</text>
                                            <text transform="matrix(1 0 0 1 54.1074 389.8793)" class="st7 st5 st8">Nome do titular</text>
                                            <text transform="matrix(1 0 0 1 479.7754 388.8793)"
                                                class="st7 st5 st8">Vencimento</text>
                                            <text transform="matrix(1 0 0 1 65.1054 241.5)" class="st7 st5 st8">Número do cartão</text>
                                            <g>
                                                <text transform="matrix(1 0 0 1 574.4219 433.8095)" id="svgexpire"
                                                    class="st2 st5 st9">01/23</text>
                                                <text transform="matrix(1 0 0 1 479.3848 417.0097)"
                                                    class="st2 st10 st11">Número</text>
                                                <text transform="matrix(1 0 0 1 479.3848 435.6762)"
                                                    class="st2 st10 st11">Válido</text>
                                                <polygon class="st2" points="554.5,421 540.4,414.2 540.4,427.9 		" />
                                            </g>
                                            <g id="cchip">
                                                <g>
                                                    <path class="st2" d="M168.1,143.6H82.9c-10.2,0-18.5-8.3-18.5-18.5V74.9c0-10.2,8.3-18.5,18.5-18.5h85.3
                                    c10.2,0,18.5,8.3,18.5,18.5v50.2C186.6,135.3,178.3,143.6,168.1,143.6z" />
                                                </g>
                                                <g>
                                                    <g>
                                                        <rect x="82" y="70" class="st12" width="1.5" height="60" />
                                                    </g>
                                                    <g>
                                                        <rect x="167.4" y="70" class="st12" width="1.5" height="60" />
                                                    </g>
                                                    <g>
                                                        <path class="st12" d="M125.5,130.8c-10.2,0-18.5-8.3-18.5-18.5c0-4.6,1.7-8.9,4.7-12.3c-3-3.4-4.7-7.7-4.7-12.3
                                        c0-10.2,8.3-18.5,18.5-18.5s18.5,8.3,18.5,18.5c0,4.6-1.7,8.9-4.7,12.3c3,3.4,4.7,7.7,4.7,12.3
                                        C143.9,122.5,135.7,130.8,125.5,130.8z M125.5,70.8c-9.3,0-16.9,7.6-16.9,16.9c0,4.4,1.7,8.6,4.8,11.8l0.5,0.5l-0.5,0.5
                                        c-3.1,3.2-4.8,7.4-4.8,11.8c0,9.3,7.6,16.9,16.9,16.9s16.9-7.6,16.9-16.9c0-4.4-1.7-8.6-4.8-11.8l-0.5-0.5l0.5-0.5
                                        c3.1-3.2,4.8-7.4,4.8-11.8C142.4,78.4,134.8,70.8,125.5,70.8z" />
                                                    </g>
                                                    <g>
                                                        <rect x="82.8" y="82.1" class="st12" width="25.8" height="1.5" />
                                                    </g>
                                                    <g>
                                                        <rect x="82.8" y="117.9" class="st12" width="26.1" height="1.5" />
                                                    </g>
                                                    <g>
                                                        <rect x="142.4" y="82.1" class="st12" width="25.8" height="1.5" />
                                                    </g>
                                                    <g>
                                                        <rect x="142" y="117.9" class="st12" width="26.2" height="1.5" />
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                        <g id="Back">
                                        </g>
                                    </svg>
                                </div>
                                <div class="back">
                                    <svg version="1.1" id="cardback" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 750 471"
                                        style="enable-background:new 0 0 750 471;" xml:space="preserve">
                                        <g id="Front">
                                            <line class="st0" x1="35.3" y1="10.4" x2="36.7" y2="11" />
                                        </g>
                                        <g id="Back">
                                            <g id="Page-1_2_">
                                                <g id="amex_2_">
                                                    <path id="Rectangle-1_2_" class="darkcolor greydark" d="M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                        C0,17.9,17.9,0,40,0z" />
                                                </g>
                                            </g>
                                            <rect y="61.6" class="st2" width="750" height="78" />
                                            <g>
                                                <path class="st3" d="M701.1,249.1H48.9c-3.3,0-6-2.7-6-6v-52.5c0-3.3,2.7-6,6-6h652.1c3.3,0,6,2.7,6,6v52.5
                    C707.1,246.4,704.4,249.1,701.1,249.1z" />
                                                <rect x="42.9" y="198.6" class="st4" width="664.1" height="10.5" />
                                                <rect x="42.9" y="224.5" class="st4" width="664.1" height="10.5" />
                                                <path class="st5"
                                                    d="M701.1,184.6H618h-8h-10v64.5h10h8h83.1c3.3,0,6-2.7,6-6v-52.5C707.1,187.3,704.4,184.6,701.1,184.6z" />
                                            </g>
                                            <text transform="matrix(1 0 0 1 621.999 227.2734)" id="svgsecurity"
                                                class="st6 st7">985</text>
                                            <g class="st8">
                                                <text transform="matrix(1 0 0 1 518.083 280.0879)" class="st9 st6 st10">CVV</text>
                                            </g>
                                            <rect x="58.1" y="378.6" class="st11" width="375.5" height="13.5" />
                                            <rect x="58.1" y="405.6" class="st11" width="421.7" height="13.5" />
                                            <text transform="matrix(1 0 0 1 59.5073 228.6099)" id="svgnameback"
                                                class="st12 st13">Lázaro Barbosa</text>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="form-container">
                            <div class="field-container">
                                <label for="name">Nome</label>
                                <input id="name" maxlength="20" type="text" name="nome_titular">
                            </div>
                            <div class="field-container">
                                <label for="cardnumber">Numero do cartão</label>
                                <input id="cardnumber" type="text" pattern="[0-9]*" inputmode="numeric" name="num_cartao">
                                <svg id="ccicon" class="ccicon" width="750" height="471" viewBox="0 0 750 471" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

                                </svg>
                            </div>
                            <div class="field-container">
                                <label for="expirationdate">Vencimento (mm/aa)</label>
                                <input id="expirationdate" type="text" pattern="[0-9]*" inputmode="numeric" name="validade">
                            </div>
                            <div class="field-container">
                                <label for="securitycode">CVV</label>
                                <input id="securitycode" type="text" pattern="[0-9]*" inputmode="numeric" name="cvv">
                            </div>
                        </div>
                    </section>

                    <div id="areaBoleto" style="display:none;">
                        <h3>Boleto gerado</h3>
                        <p>Ao finalizar, você será redirecionado.</p>
                    </div>
                                
                    <button type="button" onclick="realizarPagamento()">Realizar o Pagamento</button>

            </form>

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

    <script src="../scripts/navbar.js"></script>
    <script src="../scripts/loading.js"></script>
    <script src="../scripts/carrinho.js"></script>
    <script src="../scripts/conexão.js"></script>
    <script src="../scripts/fiado.js"></script>
    <script src="../scripts/resumoCompra.js"></script>
    <script src="../scripts/cartao.js"></script>
    <script src="../scripts/popup.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js'></script>

</body>

</html>