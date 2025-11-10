<?php
require_once("config.php");
require_once("reserva.php");
$conexion = obtenerConexion();

include_once("cabecera.html");

$idReserva = $_POST["id_reservation"];

// Ejecutar consulta
$resultado = borrarReserva($conexion, $idReserva);
$mensaje = "<div class='container'>";

if ($resultado === false) {
    $mensaje .= "<div class='alert alert-danger'>Error al eliminar la reserva. Intenta más tarde.</div>";
} else {
    // Mostrar resultados
    $mensaje .= "<div class='alert alert-success'>Se ha borrado la reserva con la ID $idReserva.</div>";
}
$mensaje .= "</div>";
$mensaje .= "<meta http-equiv='refresh' content='5;url=index.php'>";

echo $mensaje;
