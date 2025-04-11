<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $origen    = trim($_POST['origen'] ?? '');
    $destino   = trim($_POST['destino'] ?? '');
    $pasajeros = intval($_POST['pasajeros'] ?? 0);

    $sql = "SELECT id_vuelo, origen, destino, fecha, plazas_disponibles, precio FROM vuelo WHERE 1=1";
    $params = [];
    $types  = "";

    if (!empty($origen)) {
        $sql .= " AND origen LIKE ?";
        $params[] = "%" . $origen . "%";
        $types  .= "s";
    }
    if (!empty($destino)) {
        $sql .= " AND destino LIKE ?";
        $params[] = "%" . $destino . "%";
        $types  .= "s";
    }
    if ($pasajeros > 0) {
        $sql .= " AND plazas_disponibles >= ?";
        $params[] = $pasajeros;
        $types  .= "i";
    }

    if ($stmt = $conexion->prepare($sql)) {
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        // Ejecutar la consulta
        $stmt->execute();
        $result = $stmt->get_result();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Resultados de Búsqueda de Vuelos</title>
            <link rel="stylesheet" href="css/styles.css">
            <style>
                table {
                    width: 80%;
                    margin: 20px auto;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid #ccc;
                    padding: 8px;
                    text-align: center;
                }
                th {
                    background-color: #f2f2f2;
                }
                .sin-resultados {
                    text-align: center;
                    font-size: 18px;
                    color: red;
                }
                .boton-volver {
                    display: block;
                    margin: 20px auto;
                    padding: 10px 20px;
                    background-color: #4CAF50;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    text-align: center;
                    text-decoration: none;
                    font-size: 16px;
                }
                .boton-volver:hover {
                    background-color: #45a049;
                }
            </style>
        </head>
        <body>
            <h2 style="text-align:center;">Resultados de Búsqueda de Vuelos</h2>
            <?php
            if ($result->num_rows > 0) {
                echo "<table>
                        <tr>
                            <th>ID Vuelo</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Fecha</th>
                            <th>Plazas Disponibles</th>
                            <th>Precio (USD)</th>
                        </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id_vuelo']}</td>
                            <td>{$row['origen']}</td>
                            <td>{$row['destino']}</td>
                            <td>{$row['fecha']}</td>
                            <td>{$row['plazas_disponibles']}</td>
                            <td>$" . number_format($row['precio'], 2) . "</td>
                          </tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='sin-resultados'>No se encontraron vuelos que coincidan con los criterios de búsqueda.</p>";
            }
            ?>
            <a href="index.php" class="boton-volver">Volver atrás</a>
        </body>
        </html>
        <?php
        $stmt->close();
    } else {
        // Mostrar error si falla la consulta
        echo "Error en la consulta: " . $conexion->error;
    }
} else {
    // Redirect no existe formulario
    header("Location: index.php");
    exit;
}
?>
