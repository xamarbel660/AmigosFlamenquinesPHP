<?php
require_once("config.php");
require_once("reserva.php");
$conexion = obtenerConexion();

include_once("cabecera.html");

$idReserva = $_POST["id_reservation"];
$fechaHora = date('Y-m-d H:i:s', strtotime($_POST["reservation_date"]));
$numInvitados = $_POST["number_of_guests"];
$comentario = $_POST["comment"];
$idBoard = $_POST["id_board"];
$idCliente = $_POST["id_client"];

$mesas = obtenerMesas($conexion);
$clientes = obtenerClientes($conexion);

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["accion"] === "editar") {
    $idReserva = $_POST["id_reservation"];
    $fechaHora = date('Y-m-d H:i:s', strtotime($_POST["reservation_date"]));
    $numInvitados = $_POST["number_of_guests"];
    $hora = (int) date('H', strtotime($fechaHora));
    $esNoche = ($hora >= 20) ? 1 : 0;
    $comentario = $_POST["comment"];
    $idBoard = $_POST["id_board"];
    $idCliente = $_POST["id_client"];
    $resultado = editarReserva($conexion, $idReserva, $fechaHora, $numInvitados, $esNoche, $comentario, $idBoard, $idCliente);
}
?>
<div class="container" id="formularios">
    <form class="form-horizontal" name="frmEditarReserva" id="frmEditarReserva"
        method="post">
        <fieldset class="row ">
            <legend>Editar reserva</legend>

            <div class="row justify-content-between my-4">
                <!-- Cliente -->
                <div class="form-group col-12">
                    <label class="col-xs-4 control-label" for="id_client">Cliente: </label>
                    <div class="col-xs-4">
                        <select id="id_client" name="id_client" class="form-control input-md" required>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id_client'] ?>" <?= $idCliente == $cliente['id_client'] ? 'selected' : '' ?>><?= htmlspecialchars($cliente['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Fecha de la reserva -->
            <div class="form-group col-12">
                <label class="col-xs-4 control-label" for="reservation_date">Fecha: </label>
                <div class="col-xs-4">
                    <input id="reservation_date" name="reservation_date" placeholder="Fecha de la reserva"
                        class="form-control input-md" type="datetime-local" value="<?= $fechaHora ?>"  required>
                </div>
            </div>
            
            <div class="row justify-content-between my-4">
                <!-- Número de invitados de la reserva -->
                <div class="form-group col-3">
                    <label class="col-xs-4 control-label" for="number_of_guests">Número de invitados: </label>
                    <div class="col-xs-4">
                        <input id="number_of_guests" name="number_of_guests" value="<?= $numInvitados ?>" class="form-control input-md"
                            type="number" min="1" required>
                    </div>
                </div>

                <!-- Comentarios adicionales -->
                <div class="form-group col-6">
                    <label class="col-xs-4 control-label" for="comment">Comentarios: </label>
                    <div class="col-xs-4">
                        <input id="comment" name="comment" class="form-control input-md"
                            type="text" maxlength="50" value="<?= $comentario ?>" >
                    </div>
                </div>
            </div>
            <!-- Mesa -->
            <div class="form-group col-12">
                <label class="col-xs-4 control-label" for="id_board">Mesa: </label>
                <div class="col-xs-4">
                    <select id="id_board" name="id_board" class="form-control input-md" required>
                        <option value="">-- Selecciona una mesa --</option>
                        <?php foreach ($mesas as $mesa): ?>
                            <option value="<?= $mesa['id_board'] ?>" <?= $idBoard == $mesa['id_board'] ? 'selected' : '' ?>><?= htmlspecialchars($mesa['location']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Button -->
            <div class="form-group">
                <label class="col-xs-4 control-label" for="btnAceptarEditarReserva"></label>
                <div class="col-xs-4">
                    <input type="hidden" name="id_reservation" value="<?= $idReserva ?>">
                    <input type="hidden" name="accion" value="editar">
                    <input type="submit" id="btnAceptarEditarReserva" name="btnAceptarEditarReserva"
                        class="btn bg-secondary" value="Editar" />
                </div>
            </div>
        </fieldset>
    </form>
    <br>
    <?php if (isset($resultado)): ?>
        <?php if ($resultado["ok"]): ?>
            <div class="alert alert-success"><?= $resultado["message"] ?></div>
            <meta http-equiv='refresh' content='5;url=index.php'>
        <?php else: ?>
            <div class="alert alert-danger">Error: <?= htmlspecialchars($resultado["error"]) ?></div>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
<script>
    new SlimSelect({
        select: '#id_client'
    })
    new SlimSelect({
        select: '#id_board'
    })
</script>
</html>