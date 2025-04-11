<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $habitaciones_disponibles = $_POST['habitaciones_disponibles'];
    $tarifa_noche = $_POST['tarifa_noche'];

    if (empty($nombre) || empty($ubicacion) || empty($habitaciones_disponibles) || empty($tarifa_noche)) {
        echo "Todos los campos son requeridos.";
    } else {
        $sql = "INSERT INTO HOTEL (nombre, ubicacion, habitaciones_disponibles, tarifa_noche) VALUES (?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('ssii', $nombre, $ubicacion, $habitaciones_disponibles, $tarifa_noche);

        if ($stmt->execute()) {
            echo "
                Hotel registrado exitosamente! Serás redirigido en 5 segundos.
                <script>
                setTimeout(function() {
                    window.location.href = '/admin.php';
                }, 5000);
              </script>";
        } else {
            echo "
            Error al registrar el Hotel: " . $conexion->error . ". Serás redirigido en 5 segundos.
            <script>    
            setTimeout(function() {
                    window.location.href = '/admin.php';
                }, 5000);
              </script>";
        }

        $stmt->close();
    }
}

$conexion->close();
?>
