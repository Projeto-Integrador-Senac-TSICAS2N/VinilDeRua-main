<?php
require_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitização dos dados
    $nome       = mysqli_real_escape_string($con, trim($_POST['nome']));
    $autor      = mysqli_real_escape_string($con, trim($_POST['autor']));
    $preco      = floatval($_POST['preco']);
    $estoque    = intval($_POST['estoque']);
    $genero     = mysqli_real_escape_string($con, trim($_POST['genero']));
    $categoria  = isset($_POST['categoria']) ? intval($_POST['categoria']) : null; // 0 = Vinil | 1 = Vitrola
    $img_link   = mysqli_real_escape_string($con, trim($_POST['img_link']));

    // Validações padrão
    if (empty($nome) || empty($autor) || empty($genero) || empty($img_link)) {
        echo "<script>alert('⚠ Preencha todos os campos antes de continuar.'); history.back();</script>";
        exit;
    }

    if ($preco <= 0) {
        echo "<script>alert('⚠ O preço deve ser maior que zero.'); history.back();</script>";
        exit;
    }

    if ($estoque < 0) {
        echo "<script>alert('⚠ O estoque não pode ser negativo.'); history.back();</script>";
        exit;
    }

    if ($categoria !== 0 && $categoria !== 1) {
        echo "<script>alert('⚠ Selecione um tipo válido (Vinil ou Vitrola).'); history.back();</script>";
        exit;
    }

    // Comando SQL
    $sql = "INSERT INTO produtos (nome, preco, categoria, autor, genero, estoque, data_introducao, img_link)
            VALUES ('$nome', '$preco', '$categoria', '$autor', '$genero', '$estoque', 2025, '$img_link')";

    // Executa e verifica
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('✔ Produto cadastrado com sucesso!'); window.location='../pages/admPageAddP.php';</script>";
    } else {
        echo "<script>alert('❌ Erro ao cadastrar produto. Verifique os dados e tente novamente.'); history.back();</script>";
    }

} else {
    echo "<script>alert('❌ Requisição inválida.'); history.back();</script>";
}
?>
