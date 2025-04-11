<?php
require_once 'config.php';

// Asegurarse de que exista el array de carrito en la sesión
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$id = $_GET['id'] ?? 0;

// Buscar el destino por id
$destino = current(array_filter($destinos, function($d) use ($id) {
    return $d['id'] == $id;
}));

if (!$destino) {
    header('Location: index.php');
    exit;
}

// Agregar el destino al carrito
// Si ya existe, se podría incrementar la cantidad; en este prototipo se agrega solo una vez.
$_SESSION['carrito'][$id] = $destino;

// Redireccionar al carrito o de vuelta al destino
header('Location: carrito.php');
exit;
?>
