<?php
require_once 'config.php';

$id = $_GET['id'] ?? 0;
$descuento = $_SESSION['ofertas'][$id] ?? 0;

$destino = current(array_filter($destinos, function($d) use ($id) {
    return $d['id'] == $id;
}));

if(empty($destino)) {
    header('Location: index.php');
    exit;
}

$precioOriginal = $destino['precio'];
$precioDescuento = $precioOriginal * (1 - $descuento/100);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $destino['hotel'] ?></title>
    <link rel="stylesheet" href="css/destino.css">
</head>
<body>
    <div class="detalle-oferta">
        <h1><?= $destino['hotel'] ?></h1>
        <h2><?= $destino['ciudad'] ?>, <?= $destino['pais'] ?></h2>
        
        <div class="precio">
            <span style="text-decoration: line-through;">$<?= $precioOriginal ?></span>
            <span class="descuento">$<?= number_format($precioDescuento, 2) ?></span>
        </div>
        
        <p>Fecha: <?= $destino['fecha'] ?> (<?= $destino['duracion'] ?> días)</p>
        <p>¡Ahorras $<?= number_format($precioOriginal - $precioDescuento, 2) ?>!</p>
        
        <!-- Botón para agregar al carrito -->
        <a href="agregar_carrito.php?id=<?= $destino['id'] ?>" class="btn-agregar">Agregar al Carrito</a>
        
        <br><br>
        <button onclick="window.location.href='index.php'">Ver más ofertas</button>
    </div>
</body>
</html>
