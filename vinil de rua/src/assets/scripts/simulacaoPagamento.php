<?php
session_start();
require_once "conexao.php";

// Verifica se enviou forma de pagamento e total
if (!isset($_POST['total'])) {
    echo "<script>alert('Selecione uma forma de pagamento.'); history.back();</script>";
    exit;
}

// Verifica login
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Faça login para continuar.'); window.location='../pages/login.php';</script>";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$total = floatval($_POST['total']);

// Verifica carrinho
if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho']) || count($_SESSION['carrinho']) === 0) {
    echo "<script>alert('Seu carrinho está vazio.'); window.location='../pages/carrinho.php';</script>";
    exit;
}

// Buscar endereço
$resEndereco = mysqli_query($con, "SELECT id FROM enderecos WHERE usuario_id = $usuario_id LIMIT 1");
$endereco = mysqli_fetch_assoc($resEndereco);

if (!$endereco) {
    echo "<script>alert('Adicione um endereço antes de finalizar a compra.'); window.location='../pages/perfilUsuario.php';</script>";
    exit;
}

$endereco_id = $endereco['id'];

// Criar pedido (sem método de pagamento obrigatório)
mysqli_query($con, 
    "INSERT INTO pedidos (usuario_id, data_pedido, status_pedido, valor_total, endereco_id)
     VALUES ($usuario_id, NOW(), 'Aprovado', $total, $endereco_id)"
);

$pedido_id = mysqli_insert_id($con);

// Registrar itens no banco
foreach ($_SESSION['carrinho'] as $produto_id => $qtd) {

    $qtd = intval($qtd);

    mysqli_query(
        $con,
        "INSERT INTO pedido_itens (pedido_id, produto_id, quantidade)
         VALUES ($pedido_id, $produto_id, $qtd)"
    );
}

// Limpar carrinho depois do registro
unset($_SESSION['carrinho']);

// Redirecionar
echo "<script>
alert('🎉 Pedido realizado com sucesso!');
window.location='../../../index.php';
</script>";
exit;
?>
