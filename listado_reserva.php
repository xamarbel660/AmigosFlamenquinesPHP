<?php
require_once("config.php");
$conexion = obtenerConexion();

// Verifico si ha llegado el parametro de date 
if (isset($_GET['inpDate'])) {
    // Recuperar parámetro
    $reservationDate = $_GET['inpDate'];
    //Preparar la fecha para SQL
    $reservationDate = date('Y-m-d', strtotime($reservationDate));

    $sql = "SELECT r.*, b.location AS boardLocation 
            FROM reservation r 
            JOIN board b ON r.id_board = b.id_board 
            WHERE DATE(r.reservation_date) = '$reservationDate' 
            ORDER BY r.reservation_date ASC;";

} elseif(isset($_GET['checkNight'])){
    $nightReservation = $_GET['checkNight'] == 'true' ? 1 : 0;
    $sql = "SELECT r.*, b.location AS boardLocation 
            FROM reservation r 
            JOIN board b ON r.id_board = b.id_board 
            WHERE r.is_night_reservation = $nightReservation
            ORDER BY r.reservation_date ASC;";
    
}else {
    $sql = "SELECT r.*, b.location AS boardLocation 
            FROM reservation r 
            JOIN board b ON r.id_board = b.id_board 
            ORDER BY r.reservation_date ASC;";
}

// Ejecutar consulta
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// Montar tabla
$mensaje = "<h2 class='text-center'>Listado de reservas</h2>";
$mensaje .= "<table class='table table-striped'>";
$mensaje .= "<thead><tr><th>ID_RESERVA</th><th>DIA_RESERVA</th><th>NUM_CLIENTES</th><th>RESERVA_NOCHE</th><th>MESA</th><th>COMENTARIOS</th></tr></thead>";
$mensaje .= "<tbody>";

// Recorrer filas
while ($fila = mysqli_fetch_assoc($resultado)) {
    $mensaje .= "<tr><td>" . $fila['id_reservation'] . "</td>";
    $mensaje .= "<td>" . $fila['reservation_date'] . "</td>";
    $mensaje .= "<td>" . $fila['number_of_guests'] . "</td>";
    $mensaje .= "<td>" . $fila['is_night_reservation'] . "</td>";
    $mensaje .= "<td>" . $fila['boardLocation'] . "</td>";
    $mensaje .= "<td>" . $fila['comment'] . "</td>";

    $mensaje .= "<td><form class='d-inline me-1' action='editar_reserva.php' method='post'>";
    $mensaje .= "<input type='hidden' name='reserva' value='" . htmlspecialchars(json_encode($fila), ENT_QUOTES) . "' />";
    $mensaje .= "<button name='Editar' class='btn btn-primary'><i class='bi bi-pencil-square'></i></button></form>";

    $mensaje .= "<form class='d-inline' action='proceso_borrar_reserva.php' method='post'>";
    $mensaje .= "<input type='hidden' name='id_reservation' value='" . $fila['id_reservation']  . "' />";
    $mensaje .= "<button name='Borrar' class='btn btn-danger'><i class='bi bi-trash'></i></button></form>";

    $mensaje .= "</td></tr>";
}

// Cerrar tabla
$mensaje .= "</tbody></table>";

// Insertamos cabecera
include_once("cabecera.html");

// Mostrar mensaje calculado antes
echo $mensaje;
