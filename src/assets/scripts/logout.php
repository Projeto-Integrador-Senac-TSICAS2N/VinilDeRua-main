<?php
session_start();
session_unset();
session_destroy();
header("Location: /VinilDeRua-main/vinil de rua/index.php");
exit();
?>