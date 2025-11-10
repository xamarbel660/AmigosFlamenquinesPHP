<?php
require_once("config.php");
require_once("reserva.php");
$conexion = obtenerConexion();

include_once("cabecera.html");

$mesas = obtenerMesas($conexion);
$clientes = obtenerClientes($conexion);
?>
<div class="container" id="formularios">
    <form class="form-horizontal" name="frmAltaReserva" id="frmAltaReserva"
        method="get" action="listado_reserva.php" target="_blank" >
        <fieldset class="row ">
            <legend>Buscar reservas</legend>

            <div class="row justify-content-between my-4">
                <!-- Cliente -->
                <div class="form-group col-12">
                    <label class="col-xs-4 control-label" for="idCliente">Cliente: </label>
                    <div class="col-xs-4">
                        <select id="inpClient" name="inpClient" class="form-control input-md">
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
                    <input id="inpDate" name="inpDate" placeholder="Fecha de la reserva"
                        class="form-control input-md" type="date">
                </div>
            </div>
            
            <div class="row justify-content-between my-4">
                <!-- Número de invitados de la reserva -->
                <div class="form-group col-3">
                    <label class="col-xs-4 control-label" for="numInvitados">Número de invitados: </label>
                    <div class="col-xs-4">
                        <input id="numClients" name="numClients" class="form-control input-md"
                            type="number" min="1">
                    </div>
                </div>
            </div>
            <!-- Mesa -->
            <div class="form-group col-12">
                <label class="col-xs-4 control-label" for="idMesa">Mesa: </label>
                <div class="col-xs-4">
                    <select id="selBoardLocation" name="selBoardLocation" class="form-control input-md">
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
                    <input type="submit" id="btnAceptarAltaReserva"
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