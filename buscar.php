<?php
require_once 'config.php';
require_once 'filtro-viaje.php';

$filtro = new FiltroViaje(
    $_POST['nombre_hotel'] ?? '',
    $_POST['ciudad'] ?? '',
    $_POST['pais'] ?? '',
    $_POST['fecha_viaje'] ?? '',
    $_POST['duracion'] ?? 0,
    $_POST['precio_max'] ?? 0
);

$resultados = $filtro->filtrarDestinos($destinos);

echo "<style>
    .resultados {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .resultados p {
        margin: 10px 0;
    }
    .oferta {
        color: #4CAF50;
        font-weight: bold;
    }
    .no-resultados {
        text-align: center;
        font-size: 18px;
        color: #ff0000;
    }
    .boton {
        display: inline-block;
        padding: 8px 15px;
        background-color: #4CAF50;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 10px;
    }
    .boton:hover {
        background-color: #45a049;
    }
    hr {
        border: none;
        border-top: 1px solid #ccc;
        margin: 20px 0;
    }
    .boton-volver {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        text-align: center;
        text-decoration: none;
    }
    .boton-volver:hover {
        background-color: #45a049;
    }
</style>";

echo "<div class='resultados'>";
if (empty($resultados)) {
    echo "<p class='no-resultados'>No se encontraron destinos que coincidan con los criterios de búsqueda.</p>";
} else {
    foreach ($resultados as $destino) {
        echo "<p><strong>Hotel:</strong> {$destino['hotel']}</p>";
        echo "<p><strong>Ciudad:</strong> {$destino['ciudad']}</p>";
        echo "<p><strong>País:</strong> {$destino['pais']}</p>";
        echo "<p><strong>Fecha:</strong> {$destino['fecha']}</p>";
        echo "<p><strong>Duración:</strong> {$destino['duracion']} días</p>";
        echo "<p><strong>Precio:</strong> $".number_format($destino['precio'], 2)."</p>";
        if(isset($_SESSION['ofertas'][$destino['id']])) {
            $descuento = $_SESSION['ofertas'][$destino['id']];
            $nuevoPrecio = $destino['precio'] * (1 - $descuento/100);
            echo "<p class='oferta'>→ $".number_format($nuevoPrecio, 2)." ($descuento% OFF)</p>";
        }
        // Botón para agregar al carrito en cada resultado
        echo "<a href='agregar_carrito.php?id={$destino['id']}' class='boton'>Agregar al Carrito</a>";
        echo "<hr>";
    }
}
echo "<a href='index.php' class='boton-volver'>Volver atrás</a>";
echo "</div>";
