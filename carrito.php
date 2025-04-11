<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrito de Compra</title>
    <link rel="stylesheet" href="css/carrito.css">
</head>
<body>
    <div class="carrito">
        <h2>Carrito de Compra</h2>
        <?php if(empty($_SESSION['carrito'])): ?>
            <p>Tu carrito está vacío.</p>
        <?php else: ?>
            <?php foreach($_SESSION['carrito'] as $destino): ?>
                <div class="destino-item">
                    <p><strong>Hotel:</strong> <?= $destino['hotel'] ?></p>
                    <p><strong>Ciudad:</strong> <?= $destino['ciudad'] ?>, <?= $destino['pais'] ?></p>
                    <p><strong>Fecha:</strong> <?= $destino['fecha'] ?></p>
                    <p><strong>Duración:</strong> <?= $destino['duracion'] ?> días</p>
                    <p>
                        <strong>Precio:</strong>
                        <?php
                        if(isset($_SESSION['ofertas'][$destino['id']])) {
                            $descuento = $_SESSION['ofertas'][$destino['id']];
                            $nuevoPrecio = $destino['precio'] * (1 - $descuento/100);
                            echo "<span class='precio-original'>$".number_format($destino['precio'], 2)."</span>";
                            echo "<span class='precio-oferta'>$".number_format($nuevoPrecio, 2)." ($descuento% OFF)</span>";
                        } else {
                            echo "$".number_format($destino['precio'], 2);
                        }
                        ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="acciones">
            <a href="index.php" class="boton">Seguir Comprando</a>
            <a href="vaciar_carrito.php" class="boton" style="background-color:#ff0000;">Vaciar Carrito</a>
        </div>
    </div>
</body>
</html>
