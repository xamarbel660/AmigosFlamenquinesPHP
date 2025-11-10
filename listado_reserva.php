<?php
require_once("config.php");
require_once("reserva.php");
$conexion = obtenerConexion();

include_once("cabecera.html");

$cliente = $_GET['selClient'] ?? null;
$fecha = $_GET['inpDate'] ?? null;
$hora = $_GET['inpTime'] ?? null;
$numClientes = $_GET['numClients'] ?? null;
$reservaNoche = $_GET['selNight'] ?? null;
$mesa = $_GET['selBoard'] ?? null;

// Ejecutar consulta
$resultado = obtenerReservas($conexion, $cliente, $fecha, $hora, $numClientes, $reservaNoche, $mesa);
$mensaje = "<div class='container'>";

if ($resultado === false) {
    $mensaje .= "<div class='alert alert-danger'>Error al obtener las reservas. Intenta más tarde.</div>";
} else {
    // Mostrar resultados
    $mensaje .= generarTablaReservas($resultado);
}
$mensaje .= "</div>";

echo $mensaje;