<?php
require_once("config.php");
$conexion = obtenerConexion();

include_once("cabecera.html");

$fecha = $_GET['inpDate'] ?? null;
$reservaNoche = $_GET['checkNight'] ?? null;

// Ejecutar consulta
$resultado = obtenerReservas($conexion, $fecha, $reservaNoche);

if ($resultado === false) {
    echo "<div class='alert alert-danger'>Error al obtener las reservas. Intenta más tarde.</div>";
} else {
    // Mostrar resultados
    echo generarTablaReservas($resultado);
}
