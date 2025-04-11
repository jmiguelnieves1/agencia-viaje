<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Agencia de Viajes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php 
        // Muestra notificación de oferta
        mostrarNotificacionOferta($destinos); 
    ?>

    <!-- Enlace al carrito -->
    <div style="text-align: right; width: 80%; max-width: 800px; margin-bottom: 20px;">
        <a href="carrito.php" style="text-decoration:none; background-color:#4CAF50; color:white; padding:10px 20px; border-radius:5px;">Ver Carrito</a>
    </div>

    <form class="form-busqueda" method="POST" action="buscar.php">
        <div class="form-group">
            <label>Nombre del Hotel:</label>
            <input type="text" name="nombre_hotel">
        </div>
        <div class="form-group">
            <label>Ciudad:</label>
            <input type="text" name="ciudad">
        </div>
        <div class="form-group">
            <label>País:</label>
            <input type="text" name="pais">
        </div>
        <div class="form-group">
            <label>Fecha de Viaje:</label>
            <input type="date" name="fecha_viaje">
        </div>
        <div class="form-group">
            <label>Duración Mínima (días):</label>
            <input type="number" name="duracion" min="0">
        </div>
        <div class="form-group">
            <label>Precio Máximo (USD):</label>
            <input type="number" name="precio_max" min="0">
        </div>
        <button type="submit">Buscar Destinos</button>
    </form>
</body>
</html>
