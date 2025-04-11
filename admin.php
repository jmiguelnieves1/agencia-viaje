<?php 
require_once 'config.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Agencia de Viajes</title>
    <link rel="stylesheet" href="css/styles.css">
    <script>
        function validarVuelo() {
            const origen = document.getElementById('origen').value;
            const destino = document.getElementById('destino').value;
            const fecha = document.getElementById('fecha').value;
            const plazas = document.getElementById('plazas_disponibles').value;
            const precio = document.getElementById('precio').value;

            if (origen === "" || destino === "" || fecha === "" || plazas === "" || precio === "") {
                alert("Por favor, complete todos los campos del formulario de vuelo.");
                return false;
            }

            if (isNaN(plazas) || plazas <= 0) {
                alert("El número de plazas debe ser un número positivo.");
                return false;
            }

            if (isNaN(precio) || precio <= 0) {
                alert("El precio debe ser un número positivo.");
                return false;
            }

            return true;
        }

        function validarHotel() {
            const nombre = document.getElementById('nombre').value;
            const ubicacion = document.getElementById('ubicacion').value;
            const habitaciones = document.getElementById('habitaciones_disponibles').value;
            const tarifa = document.getElementById('tarifa_noche').value;

            // Validar campos vacíos
            if (nombre === "" || ubicacion === "" || habitaciones === "" || tarifa === "") {
                alert("Por favor, complete todos los campos del formulario de hotel.");
                return false;
            }

            if (isNaN(habitaciones) || habitaciones <= 0) {
                alert("El número de habitaciones debe ser un número positivo.");
                return false;
            }

            if (isNaN(tarifa) || tarifa <= 0) {
                alert("La tarifa por noche debe ser un número positivo.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <h1>Panel de Administración</h1>

    <h2>Hoteles con más de 2 reservas</h2>
    <table class="table-vuelos-hoteles">
        <tr>
            <th>ID Hotel</th>
            <th>Nombre</th>
            <th>Ubicación</th>
            <th>Número de Reservas</th>
        </tr>
        <?php
        $sql_hoteles_reservados = "SELECT H.id_hotel, H.nombre, H.ubicacion, COUNT(R.id_reserva) as num_reservas 
                                  FROM hotel H 
                                  JOIN reserva R ON H.id_hotel = R.id_hotel 
                                  GROUP BY H.id_hotel 
                                  HAVING COUNT(R.id_reserva) > 2";
        
        $result_hoteles_reservados = $conexion->query($sql_hoteles_reservados);
        if ($result_hoteles_reservados->num_rows > 0) {
            while ($row = $result_hoteles_reservados->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_hotel']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['ubicacion']}</td>
                        <td>{$row['num_reservas']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No hay hoteles con más de 2 reservas.</td></tr>";
        }
        ?>
    </table>

    <!--Reservas -->
    <h2>Reservas</h2>
        <table class="table-vuelos-hoteles">
            <tr>
                <th>ID Reserva</th>
                <th>Nombre hotel</th>
                <th>Nro de vuelo</th>
                <th>Fecha reserva</th>
                <th>Precio vuelo</th>
            </tr>
            <?php
            $sql_vuelos = "SELECT R.id_reserva, H.nombre, R.id_vuelo, R.fecha_reserva, V.precio FROM reserva R JOIN vuelo V ON R.id_vuelo = V.id_vuelo JOIN hotel H on R.id_hotel = H.id_hotel" ;
            $result_vuelos = $conexion->query($sql_vuelos);

            if ($result_vuelos->num_rows > 0) {
                while ($row = $result_vuelos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_reserva'] . "</td>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['id_vuelo'] . "</td>";
                    echo "<td>" . $row['fecha_reserva'] . "</td>";
                    echo "<td>" . $row['precio'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay vuelos registrados.</td></tr>";
            }
            ?>
        </table>

        <!--Vuelos -->
        <h2>Vuelos</h2>
        <table class="table-vuelos-hoteles">
            <tr>
                <th>ID Vuelo</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Fecha</th>
                <th>Plazas Disponibles</th>
                <th>Precio</th>
            </tr>
            <?php
            $sql_vuelos = "SELECT * FROM VUELO";
            $result_vuelos = $conexion->query($sql_vuelos);

            if ($result_vuelos->num_rows > 0) {
                while ($row = $result_vuelos->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_vuelo'] . "</td>";
                    echo "<td>" . $row['origen'] . "</td>";
                    echo "<td>" . $row['destino'] . "</td>";
                    echo "<td>" . $row['fecha'] . "</td>";
                    echo "<td>" . $row['plazas_disponibles'] . "</td>";
                    echo "<td>" . $row['precio'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay vuelos registrados.</td></tr>";
            }
            ?>
        </table>

    <!-- Sección para agregar un vuelo -->
    <form id="form-vuelo" class="form-busqueda" action="admin_vuelo.php" method="POST" onsubmit="return validarVuelo()">
        <h2>Agregar Nuevo Vuelo</h2>
        <div class="form-group">
            <label for="origen">Origen:</label>
            <input type="text" id="origen" name="origen" required><br><br>
        </div>

        <div class="form-group">
            <label for="destino">Destino:</label>
            <input type="text" id="destino" name="destino" required><br><br>
        </div>

        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required><br><br>
        </div>

        <div class="form-group">
            <label for="plazas_disponibles">Plazas Disponibles:</label>
            <input type="number" id="plazas_disponibles" name="plazas_disponibles" required><br><br>
        </div>

        <div class="form-group">
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" required><br><br>
        </div>

        <button type="submit">Registrar vuelo</button>
    </form>


    <!-- Hoteles  -->
<h2>Hoteles</h2>
<table class="table-vuelos-hoteles">
    <tr>
        <th>ID Hotel</th>
        <th>Nombre</th>
        <th>Ubicación</th>
        <th>Habitaciones Disponibles</th>
        <th>Tarifa por Noche</th>
    </tr>
    <?php
    $sql_hoteles = "SELECT * FROM HOTEL";
    $result_hoteles = $conexion->query($sql_hoteles);

    if ($result_hoteles->num_rows > 0) {
        while ($row = $result_hoteles->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id_hotel'] . "</td>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['ubicacion'] . "</td>";
            echo "<td>" . $row['habitaciones_disponibles'] . "</td>";
            echo "<td>" . $row['tarifa_noche'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No hay hoteles registrados.</td></tr>";
    }
    ?>
</table>

    <!-- Sección para agregar un hotel -->
    <form id="form-hotel" class="form-busqueda" action="admin_hotel.php" method="POST" onsubmit="return validarHotel()">
        <h2>Agregar Nuevo Hotel</h2>
        <div class="form-group">
            <label for="nombre">Nombre del Hotel:</label>
            <input type="text" id="nombre" name="nombre" required><br><br>
        </div>

        <div class="form-group">
            <label for="ubicacion">Ubicación:</label>
            <input type="text" id="ubicacion" name="ubicacion" required><br><br>
        </div>

        <div class="form-group">
            <label for="habitaciones_disponibles">Habitaciones Disponibles:</label>
            <input type="number" id="habitaciones_disponibles" name="habitaciones_disponibles" required><br><br>
        </div>

        <div class="form-group">
            <label for="tarifa_noche">Tarifa por Noche:</label>
            <input type="number" id="tarifa_noche" name="tarifa_noche" required><br><br>
        </div>

        <button type="submit">Registrar Hotel</button>
    </form>



</body>
</html>
