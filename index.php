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
        mostrarNotificacionOferta(); 
    ?>

    <!-- Enlace al carrito -->
    <div style="text-align: right; width: 80%; max-width: 800px; margin-bottom: 20px;">
        <a href="carrito.php" style="text-decoration:none; background-color:#4CAF50; color:white; padding:10px 20px; border-radius:5px;">Ver Carrito</a>
    </div>

    <h2>Buscar Hoteles</h2>
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

    <h2>Buscar Vuelos</h2>
    <form class="form-busqueda" method="POST" action="buscar_vuelos.php">
        <div class="form-group">
            <label>Origen:</label>
            <input type="text" name="origen" required>
        </div>
        <div class="form-group">
            <label>Destino:</label>
            <input type="text" name="destino" required>
        </div>
        <div class="form-group">
            <label>Fecha de Salida:</label>
            <input type="date" name="fecha_salida" required>
        </div>
        <div class="form-group">
            <label>Cantidad de Pasajeros:</label>
            <input type="number" name="pasajeros" min="1" required>
        </div>
        <button type="submit">Buscar Vuelos</button>
    </form>
</body>
</html>
