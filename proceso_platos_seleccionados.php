<?php
require_once('config.php');
$conexion = obtenerConexion();

// Datos de entrada
$idPlato = $_GET['idPlatoSeleccionado'];

$sql = "SELECT * FROM `plate` WHERE `id_plate` LIKE '$idPlato';";

$resultado = mysqli_query($conexion, $sql);

while ($fila = mysqli_fetch_assoc($resultado)) {
    $datos[] = $fila; // Insertar la fila en el array
}

responder($datos, true, "Datos recuperados", $conexion);