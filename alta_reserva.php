<?php
require_once("config.php");
require_once("reserva.php");
$conexion = obtenerConexion();

include_once("cabecera.html");

$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fechaHora = date('Y-m-d H:i:s', strtotime($_POST["dateReserva"]));
    $hora = (int) date('H', strtotime($fechaHora));
    $esNoche = ($hora >= 20) ? 1 : 0;
    $numInvitados = $_POST["numInvitados"];
    $comentario = $_POST["comentario"];
    $idBoard = $_POST["idMesa"];
    $idCliente = $_POST["idCliente"];

    $resultado = crearReserva($conexion, $fechaHora, $numInvitados, $esNoche, $comentario, $idBoard, $idCliente);
    $mensaje = is_numeric($resultado) ? "Reserva creada con ID: $resultado" : $resultado;
}

$mesas = obtenerMesas($conexion);
$clientes = obtenerClientes($conexion);

?>
<div class="container" id="formularios">
    <form class="form-horizontal" name="frmAltaReserva" id="frmAltaReserva"
        method="post">
        <fieldset class="row ">
            <legend>Alta de reserva</legend>

            <div class="row justify-content-between my-4">
                <!-- Cliente -->
                <div class="form-group col-12">
                    <label class="col-xs-4 control-label" for="idCliente">Cliente: </label>
                    <div class="col-xs-4">
                        <select id="idCliente" name="idCliente" class="form-control input-md" required>
                            <option value="">-- Selecciona un cliente --</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id_client'] ?>"><?= htmlspecialchars($cliente['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Fecha de la reserva -->
            <div class="form-group col-12">
                <label class="col-xs-4 control-label" for="dateReserva">Fecha: </label>
                <div class="col-xs-4">
                    <input id="dateReserva" name="dateReserva" placeholder="Fecha de la reserva"
                        class="form-control input-md" type="datetime-local" required>
                </div>
            </div>
            
            <div class="row justify-content-between my-4">
                <!-- Número de invitados de la reserva -->
                <div class="form-group col-3">
                    <label class="col-xs-4 control-label" for="numInvitados">Número de invitados: </label>
                    <div class="col-xs-4">
                        <input id="numInvitados" name="numInvitados" value="1" class="form-control input-md"
                            type="number" min="1" required>
                    </div>
                </div>

                <!-- Comentarios adicionales -->
                <div class="form-group col-6">
                    <label class="col-xs-4 control-label" for="comentario">Comentarios: </label>
                    <div class="col-xs-4">
                        <input id="comentario" name="comentario" class="form-control input-md"
                            type="text" maxlength="50">
                    </div>
                </div>
            </div>
            <!-- Mesa -->
            <div class="form-group col-12">
                <label class="col-xs-4 control-label" for="idMesa">Mesa: </label>
                <div class="col-xs-4">
                    <select id="idMesa" name="idMesa" class="form-control input-md" required>
                        <option value="">-- Selecciona una mesa --</option>
                        <?php foreach ($mesas as $mesa): ?>
                            <option value="<?= $mesa['id_board'] ?>"><?= htmlspecialchars($mesa['location']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <!-- Button -->
            <div class="form-group">
                <label class="col-xs-4 control-label" for="btnAceptarAltaReserva"></label>
                <div class="col-xs-4">
                    <input type="submit" id="btnAceptarAltaReserva" name="btnAceptarAltaReserva"
                        class="btn bg-secondary" value="Aceptar" />
                </div>
            </div>
        </fieldset>
    </form>
    <?php if ($mensaje): ?>
        <p><strong><?= htmlspecialchars($mensaje) ?></strong></p>
    <?php endif; ?>
</div>
</body>

</html>