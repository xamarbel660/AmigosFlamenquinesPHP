<?php
function obtenerReservas($conexion, $fecha = null, $reservaNoche = null) {
    try {
        if ($fecha) {
            $fecha = date('Y-m-d', strtotime($fecha));
            $sql = "SELECT r.*, b.location AS boardLocation 
                    FROM reservation r 
                    JOIN board b ON r.id_board = b.id_board 
                    WHERE DATE(r.reservation_date) = ? 
                    ORDER BY r.reservation_date ASC";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("s", $fecha);
        } elseif ($reservaNoche !== null) {
            $reservaNoche = ($reservaNoche === 'true' || $reservaNoche === '1') ? 1 : 0;
            $sql = "SELECT r.*, b.location AS boardLocation 
                    FROM reservation r 
                    JOIN board b ON r.id_board = b.id_board 
                    WHERE r.is_night_reservation = ? 
                    ORDER BY r.reservation_date ASC";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("i", $reservaNoche);
        } else {
            $sql = "SELECT r.*, b.location AS boardLocation 
                    FROM reservation r 
                    JOIN board b ON r.id_board = b.id_board 
                    ORDER BY r.reservation_date ASC";
            $stmt = $conexion->prepare($sql);
        }

        $stmt->execute();
        return $stmt->get_result();
    } catch (mysqli_sql_exception $e) {
        error_log("Error al obtener reservas: " . $e->getMessage());
    }
}

function generarTablaReservas($resultado) {
    $mensaje = "<h2 class='text-center'>Listado de reservas</h2>";
    $mensaje .= "<table class='table table-striped'>";
    $mensaje .= "<thead><tr>
                    <th>ID_RESERVA</th>
                    <th>DIA_RESERVA</th>
                    <th>NUM_CLIENTES</th>
                    <th>RESERVA_NOCHE</th>
                    <th>MESA</th>
                    <th>COMENTARIOS</th>
                    <th>ACCIONES</th>
                 </tr></thead><tbody>";

    while ($fila = $resultado->fetch_assoc()) {
        $mensaje .= "<tr>
                        <td>{$fila['id_reservation']}</td>
                        <td>{$fila['reservation_date']}</td>
                        <td>{$fila['number_of_guests']}</td>
                        <td>{$fila['is_night_reservation']}</td>
                        <td>{$fila['boardLocation']}</td>
                        <td>{$fila['comment']}</td>
                        <td>
                            <form class='d-inline me-1' action='editar_reserva.php' method='post'>
                                <input type='hidden' name='reserva' value='" . htmlspecialchars(json_encode($fila), ENT_QUOTES) . "' />
                                <button name='Editar' class='btn btn-primary'><i class='bi bi-pencil-square'></i></button>
                            </form>
                            <form class='d-inline' action='proceso_borrar_reserva.php' method='post'>
                                <input type='hidden' name='id_reservation' value='{$fila['id_reservation']}' />
                                <button name='Borrar' class='btn btn-danger'><i class='bi bi-trash'></i></button>
                            </form>
                        </td>
                    </tr>";
    }

    $mensaje .= "</tbody></table>";
    return $mensaje;
}

>