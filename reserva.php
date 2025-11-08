<?php
function obtenerReservas($conexion, $fecha = null, $reservaNoche = null) {
    try {
        $sql = "SELECT r.*, b.location AS boardLocation, c.name AS clientName
                FROM reservation r 
                JOIN board b ON r.id_board = b.id_board
                JOIN client c ON r.id_client = c.id_client";
        $params = [];
        $types = "";

        if ($fecha) {
            $fecha = date('Y-m-d', strtotime($fecha));
            $sql .= " WHERE DATE(r.reservation_date) = ?";
            $params[] = $fecha;
            $types .= "s";
        } elseif ($reservaNoche !== null) {
            $reservaNoche = ($reservaNoche === 'true' || $reservaNoche === '1') ? 1 : 0;
            $sql .= " WHERE r.is_night_reservation = ?";
            $params[] = $reservaNoche;
            $types .= "i";
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

function generarTablaReservas($resultado) {
    $mensaje = "<h2 class='text-center'>Listado de reservas</h2>";
    $mensaje .= "<table class='table table-striped'>";
    $mensaje .= "<thead><tr>
                    <th>ID_RESERVA</th>
                    <th>CLIENTE</th>
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
                        <td>{$fila['clientName']}</td>
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

function crearReserva($conexion, $fechaHora, $numInvitados, $esNoche, $comentario, $idBoard, $idCliente) {
    try {
        if (!DateTime::createFromFormat('Y-m-d H:i:s', $fechaHora)) {
            throw new Exception("Formato de fecha inválido. Usa 'Y-m-d H:i:s'");
        }

        if (!is_numeric($numInvitados) || $numInvitados <= 0) {
            throw new Exception("Número de invitados inválido.");
        }

        $esNoche = ($esNoche === true || $esNoche === '1' || $esNoche === 'true') ? 1 : 0;

        $sql = "INSERT INTO reservation (reservation_date, number_of_guests, is_night_reservation, comment, id_board, id_client)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conexion->error);
        }

        $stmt->bind_param("siisii", $fechaHora, $numInvitados, $esNoche, $comentario, $idBoard, $idCliente);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            return $conexion->insert_id;
        } else {
            throw new Exception("No se pudo insertar la reserva.");
        }
    } catch (Exception $e) {
        error_log("Error al crear reserva: " . $e->getMessage());
        return false;
    }
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
