<?php
http_response_code(404);
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página Não Encontrada</title>
    <link rel="stylesheet" href="/VinilDeRua-main/vinil%20de%20rua/src/assets/styles/style404.css">
</head>

<body>
    <div id="preloader">
        <img src="https://i.ibb.co/qYwvJYpw/loading.gif" alt="loading">
    </div>

    <main>
        <img src="https://i.ibb.co/Z6Vff5HQ/error.gif" alt="error">
        <h2>Oops! Página não encontrada.</h2>
        <a class="btn-voltar" href="/VinilDeRua-main/vinil%20de%20rua/index.php">Voltar ao início</a>
    </main>

    <!-- Caminho corrigido -->
    <script src="/VinilDeRua-main/vinil%20de%20rua/src/assets/scripts/loading.js"></script>
</body>
</html>