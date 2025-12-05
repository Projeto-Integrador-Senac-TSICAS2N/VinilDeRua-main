<?php
require_once "conexao.php";

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM produtos WHERE id = $id";

    if(mysqli_query($con, $sql)) {
        echo "<script>alert('Produto removido com sucesso!'); window.location='../pages/admPageRemoveP.php';</script>";
    } else {
        echo "<script>alert('Erro ao remover produto!'); history.back();</script>";
    }

} else {
    echo "<script>alert('ID inválido!'); history.back();</script>";
}
?>
