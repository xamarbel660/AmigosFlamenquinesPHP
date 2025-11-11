<?php
require_once('config.php');
$conexion = obtenerConexion();

// Datos de entrada

if (isset($_GET['idPlatoSeleccionado'])) {
    $idPlato = $_GET['idPlatoSeleccionado'];
    $sql = "SELECT * FROM `plate` WHERE `id_plate` LIKE '$idPlato';";
    $resultado = mysqli_query($conexion, $sql);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $datos[] = $fila; // Insertar la fila en el array
    }
    responder($datos, true, "Datos recuperados", $conexion);
} elseif (isset($_GET['idDelPedido'])) {
    $idPedido = $_GET['idDelPedido'];
    $sql = "SELECT p.id_plate, p.name, od.quantity, od.notes, p.price FROM client_order AS co
    JOIN order_dish AS od ON co.id_client_order = od.id_cash_order
    JOIN plate AS p ON od.id_plate = p.id_plate
    WHERE co.id_client_order = $idPedido;";

    $resultado = mysqli_query($conexion, $sql);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $datos[] = $fila; // Insertar la fila en el array
    }
    responder($datos, true, "Datos recuperados", $conexion);
}
