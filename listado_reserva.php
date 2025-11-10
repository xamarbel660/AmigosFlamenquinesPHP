<?php
require_once("config.php");
require_once("reserva.php");
$conexion = obtenerConexion();

include_once("cabecera.html");

$cliente = $_GET['inpClient'] ?? null;
$fecha = $_GET['inpDate'] ?? null;
$numClientes = $_GET['numClients'] ?? null;
$reservaNoche = $_GET['checkNight'] ?? null;
$mesa = $_GET['selBoardLocation'] ?? null;

// Ejecutar consulta
$resultado = obtenerReservas($conexion, $cliente, $fecha, $numClientes, $reservaNoche, $mesa);

if ($resultado === false) {
    echo "<div class='alert alert-danger'>Error al obtener las reservas. Intenta más tarde.</div>";
} else {
    // Mostrar resultados
    echo generarTablaReservas($resultado);
}
