<?php
require_once "conexao.php";

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

$result = $con->query($sql);

$labels = [];
$values = [];

while ($row = $result->fetch_assoc()) {
    $labels[] = $row['genero'];
    $values[] = intval($row['total']);
}

echo json_encode([
    'labels' => $labels,
    'valores' => $values
]);
?>
