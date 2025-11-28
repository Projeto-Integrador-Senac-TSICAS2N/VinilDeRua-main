<?php
require_once "conexao.php";

$termo = $_GET['buscar'] ?? "";
$categoria = $_GET['categoria'] ?? "";
$status = $_GET['status'] ?? "";

$sql = "SELECT id, nome, autor, preco, estoque, img_link FROM produtos WHERE 1";

// Busca
if ($termo !== "") {
    $termo = $con->real_escape_string($termo);
    $sql .= " AND (nome LIKE '%$termo%' OR autor LIKE '%$termo%' OR id LIKE '%$termo%')";
}

// Filtro categoria
if ($categoria !== "" && $categoria !== "todas") {
    $categoria = $con->real_escape_string($categoria);
    $sql .= " AND categoria = '$categoria'";
}

// Filtro estoque
if ($status === "estoque") {
    $sql .= " AND estoque > 0";
} elseif ($status === "zerado") {
    $sql .= " AND estoque = 0";
}

$res = $con->query($sql);

// Se não tiver nada
if ($res->num_rows === 0) {
    echo "<p>Nenhum produto encontrado.</p>";
    exit;
}

while ($row = $res->fetch_assoc()) {
    $img = $row['img_link'] ?: "https://via.placeholder.com/120?text=SEM+IMAGEM";

    echo "
    <div style='border:1px solid #ccc; padding:15px; margin-bottom:10px; border-radius:8px; display:flex; gap:15px; align-items:center'>
        <img src='{$img}' width='90' height='90' style='border-radius:5px; object-fit:cover'>
        <div>
            <strong>{$row['nome']} - {$row['autor']}</strong><br>
            R$ " . number_format($row['preco'], 2, ',', '.') . "<br>
            <small>Em estoque: {$row['estoque']}</small><br>
            <small>ID: {$row['id']}</small>
        </div>
    </div>";
}
