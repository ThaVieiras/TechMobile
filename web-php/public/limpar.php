<?php
session_start();
session_destroy(); // Remove tudo da sessão, incluindo o carrinho
header("Location: produtos.php");
exit;
?>