<?php
function obtenerReservas($conexion, $cliente = null, $fecha = null, $hora = null, $numClientes = null, $reservaNoche = null, $mesa = null) {
    try {
        $sql = "SELECT r.*, b.location AS board_location, c.name AS client_name, c.is_vip AS client_is_vip
                FROM reservation r 
                JOIN board b ON r.id_board = b.id_board
                JOIN client c ON r.id_client = c.id_client";
        $params = [];
        $where = [];
        $types = "";

        if ($cliente) {
            $where[] = "r.id_client = ?";
            $params[] = $cliente;
            $types .= "s";
        }
        if ($fecha) {
            $where[] = "DATE(r.reservation_date) = ?";
            $params[] = $fecha;
            $types .= "s";
        }
        if ($hora) {
            $where[] = "TIME(r.reservation_date) = ?";
            $params[] = $hora;
            $types .= "s";
        }
        if ($numClientes) {
            $where[] = "r.number_of_guests = ?";
            $params[] = $numClientes;
            $types .= "i";
        }
        if (isset($reservaNoche) && $reservaNoche !== '') {
            $where[] = "r.is_night_reservation = ?";
            $params[] = $reservaNoche;
            $types .= "i";
        }
        if ($mesa) {
            $where[] = "r.id_board = ?";
            $params[] = $mesa;
            $types .= "s";
        }

        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY r.reservation_date ASC";
        $stmt = $conexion->prepare($sql);

        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        return $stmt->get_result();
    } catch (Exception $e) {
        error_log("Error al obtener reservas: " . $e->getMessage());
        return false;
    }
}

function crearReserva($conexion, $fechaHora, $numInvitados, $esNoche, $comentario, $idBoard, $idCliente) {
    try {
        if (!DateTime::createFromFormat('Y-m-d H:i:s', $fechaHora)) {
            throw new Exception("Formato de fecha inválido. Usa 'Y-m-d H:i:s'");
        }

        if (!is_numeric($numInvitados) || $numInvitados <= 0) {
            throw new Exception("Número de invitados inválido.");
        }

        $sql = "INSERT INTO reservation (reservation_date, number_of_guests, is_night_reservation, comment, id_board, id_client)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }

        $stmt->bind_param("siisii", $fechaHora, $numInvitados, $esNoche, $comentario, $idBoard, $idCliente);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return ["ok" => true, "message" => "Reserva creada con ID: ".$conexion->insert_id];
        } else {
            throw new Exception("No se pudo insertar la reserva.");
        }
    } catch (Exception $e) {
        error_log("Error al crear reserva: " . $e->getMessage());
        return ["ok" => false, "error" => $e->getMessage()];
    }
}

function editarReserva($conexion, $idReserva, $fechaHora, $numInvitados, $esNoche, $comentario, $idBoard, $idCliente) {
    try {
        if(!$idReserva) {
            throw new Exception("Error: idReserva no pasado como parámetro.");
        }

        if (!DateTime::createFromFormat('Y-m-d H:i:s', $fechaHora)) {
            throw new Exception("Formato de fecha inválido. Usa 'Y-m-d H:i:s'");
        }

        if (!is_numeric($numInvitados) || $numInvitados <= 0) {
            throw new Exception("Número de invitados inválido.");
        }

        $sql = "UPDATE reservation SET reservation_date = ?, 
                number_of_guests = ?, 
                is_night_reservation = ?, 
                comment = ?, 
                id_board = ?, 
                id_client = ? 
                WHERE id_reservation = ?";

        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }

        $stmt->bind_param("siisiii", $fechaHora, $numInvitados, $esNoche, $comentario, $idBoard, $idCliente, $idReserva);
        $stmt->execute();

        if ($stmt->affected_rows >= 0) {
            return ["ok" => true, "message" => "Reserva con ID ".$idReserva." editada correctamente."];
        } else {
            throw new Exception("No se pudo editar la reserva.");
        }
    } catch (Exception $e) {
        error_log("Error al editar la reserva: " . $e->getMessage());
        return ["ok" => false, "error" => $e->getMessage()];
    }
}

function borrarReserva($conexion, $idReserva) {
    try {
        if (!is_numeric($idReserva)) {
            throw new Exception("ID de reserva inválido.");
        }

        $sql = "DELETE FROM reservation WHERE id_reservation = ?";

        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }

        $stmt->bind_param("i", $idReserva);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return true;
        } else {
            throw new Exception("No se pudo borrar la reserva.");
        }
    } catch (Exception $e) {
        error_log("Error al borrar la reserva: " . $e->getMessage());
        return false;
    } 
}

function generarTablaReservas($resultado) {
    $mensaje = "<h2 class='text-center'>Listado de reservas</h2>";
    $mensaje .= "<table class='table table-striped text-center'>";
    $mensaje .= "<thead><tr>
                    <th>CLIENTE</th>
                    <th>DIA_RESERVA</th>
                    <th>HORA_RESERVA</th>
                    <th>NUM_INVITADOS</th>
                    <th>RESERVA_NOCHE</th>
                    <th>MESA</th>
                    <th>COMENTARIOS</th>
                    <th>ACCIONES</th>
                 </tr></thead><tbody>";

    while ($fila = $resultado->fetch_assoc()) {
        $idReservation = $fila['id_reservation'];
        $clientNameReservation = $fila['client_name'];
        $clientIsVip = $fila['client_is_vip']?"VIP":"";
        $reservationDateReservation = date('d-m-Y', strtotime($fila['reservation_date']));
        $reservationTimeReservation = date('H:i:s', strtotime($fila['reservation_date']));
        $numberGuestsReservation = $fila['number_of_guests'];
        $nightReservation = $fila['is_night_reservation']?"Sí":"No";
        $boardLocationReservation = $fila['board_location'];
        $commentReservation = $fila['comment'];
        $mensaje .= "<tr>
                        <td>{$clientNameReservation}<sup> {$clientIsVip}</sup></td>
                        <td>{$reservationDateReservation}</td>
                        <td>{$reservationTimeReservation}</td>
                        <td>{$numberGuestsReservation}</td>
                        <td>{$nightReservation}</td>
                        <td>{$boardLocationReservation}</td>
                        <td>{$commentReservation}</td>
                        <td>
                            <form class='d-inline me-1' action='editar_reserva.php' method='post'>
                                <input type='hidden' name='id_reservation' value='" . $idReservation . "' />
                                <input type='hidden' name='reservation_date' value='" . $fila['reservation_date'] . "' />
                                <input type='hidden' name='number_of_guests' value='" . $numberGuestsReservation . "' />
                                <input type='hidden' name='is_night_reservation' value='" . $nightReservation . "' />
                                <input type='hidden' name='comment' value='" . $commentReservation . "' />
                                <input type='hidden' name='id_board' value='" . $fila["id_board"] . "' />
                                <input type='hidden' name='id_client' value='" . $fila["id_client"] . "' />
                                <button name='Editar' class='btn btn-primary'><i class='bi bi-pencil-square'></i></button>
                            </form>
                            <form class='d-inline' action='borrar_reserva.php' method='post'>
                                <input type='hidden' name='id_reservation' value='{$idReservation}' />
                                <button name='Borrar' class='btn btn-danger'><i class='bi bi-trash'></i></button>
                            </form>
                        </td>
                    </tr>";
    }

    $mensaje .= "</tbody></table>";
    return $mensaje;
}

function obtenerMesas($conexion) {
    $mesas = [];
    $resultMesas = $conexion->query("SELECT id_board, location FROM board ORDER BY location ASC");
    if ($resultMesas) {
        while ($row = $resultMesas->fetch_assoc()) {
            $mesas[] = $row;
        }
    }
    return $mesas;
}

function obtenerClientes($conexion) {
    $clientes = [];
    $resultClientes = $conexion->query("SELECT id_client, name FROM client ORDER BY name ASC");
    if ($resultClientes) {
        while ($row = $resultClientes->fetch_assoc()) {
            $clientes[] = $row;
        }
    }
    return $clientes;
}
