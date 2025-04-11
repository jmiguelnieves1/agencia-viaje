<?php
require_once 'config.php';

// Vaciar el carrito
unset($_SESSION['carrito']);

// Redirigir de vuelta al carrito
header('Location: carrito.php');
exit;
?>