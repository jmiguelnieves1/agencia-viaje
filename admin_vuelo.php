<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $fecha = $_POST['fecha'];
    $plazas_disponibles = $_POST['plazas_disponibles'];
    $precio = $_POST['precio'];

    if (empty($origen) || empty($destino) || empty($fecha) || empty($plazas_disponibles) || empty($precio)) {
        echo "Todos los campos son requeridos.";
    } else {
        $sql = "INSERT INTO VUELO (origen, destino, fecha, plazas_disponibles, precio) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('sssid', $origen, $destino, $fecha, $plazas_disponibles, $precio);

        if ($stmt->execute()) {
            echo "
                Vuelo registrado exitosamente! Serás redirigido en 5 segundos.
                <script>
                setTimeout(function() {
                    window.location.href = '/admin.php';
                }, 5000);
              </script>";
        } else {
            echo "
                Error al registrar el vuelo: " . $conexion->error . ". Serás redirigido en 5 segundos.
                <script>
                setTimeout(function() {
                    window.location.href = '/admin.php';
                }, 5000);
              </script>";
            echo "Error al registrar el vuelo: " . $conexion->error;
        }

        // Cerrar la conexión
        $stmt->close();
    }
}

$conexion->close();

?>
