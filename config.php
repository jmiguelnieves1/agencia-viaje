<?php
// Mejoras de seguridad
$cookieParams = [
  'lifetime' => 0,               
  'path'     => '/',
  'domain'   => $_SERVER['HTTP_HOST'],
  'secure'   => true,            
  'httponly' => true,            
  'samesite' => 'Strict'
];
session_set_cookie_params($cookieParams);

// Duracion de la sesión en el servidor (1 hora)
ini_set('session.gc_maxlifetime', 3600);

session_start();

$host = 'localhost'; 
$usuario = 'root';
$clave = ''; 
$base_de_datos = 'agencia';

$conexion = new mysqli($host, $usuario, $clave, $base_de_datos);
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Función para mostrar la notificación de oferta
function mostrarNotificacionOferta() {
  global $conexion;

  $sql = "
      SELECT id_hotel, nombre, ubicacion, tarifa_noche 
      FROM hotel
      WHERE habitaciones_disponibles > 0"; 
  $resultado = $conexion->query($sql);

  if ($resultado->num_rows > 0) {
      $destinos = $resultado->fetch_all(MYSQLI_ASSOC);
      $destinoOferta = $destinos[array_rand($destinos)];

      // Generar un descuento aleatorio entre 5% y 50%
      $descuento = rand(5, 50); 

      // Almacenar el descuento en la sesion
      $_SESSION['ofertas'][$destinoOferta['id_hotel']] = $descuento;

      // Mostrar la notificación de oferta
      echo "<a href='destino.php?id={$destinoOferta['id_hotel']}' class='notificacion-oferta'>
              <h3>¡Oferta Limitada!</h3>
              <p>{$destinoOferta['nombre']} - {$destinoOferta['ubicacion']}</p>
              <p>{$descuento}% DE DESCUENTO</p>
            </a>
            <script>
              setTimeout(() => {
                  document.querySelector('.notificacion-oferta').style.display = 'none';
              }, 10000);
            </script>";
  } else {
      // Si no hay destinos disponibles
      echo "<p>No hay ofertas disponibles en este momento.</p>";
  }
}
?>