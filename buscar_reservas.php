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
                    <label class="col-xs-4 control-label" for="selClient">Cliente: </label>
                    <div class="col-xs-4">
                        <select id="selClient" name="selClient" class="form-control input-md">
                            <option value="">-- Sin filtro --</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id_client'] ?>"><?= htmlspecialchars($cliente['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Fecha de la reserva -->
            <div class="form-group col-12">
                <label class="col-xs-4 control-label" for="inpDate">Fecha: </label>
                <div class="col-xs-4">
                    <input id="inpDate" name="inpDate" placeholder="Fecha de la reserva"
                        class="form-control input-md" type="date">
                </div>
            </div>

            <!-- Fecha de la reserva -->
            <div class="form-group col-12">
                <label class="col-xs-4 control-label" for="inpTime">Hora: </label>
                <div class="col-xs-4">
                    <input id="inpTime" name="inpTime" placeholder="Hora de la reserva"
                        class="form-control input-md" type="time">
                </div>
            </div>
            
            <div class="row justify-content-between my-4">
                <!-- Número de invitados de la reserva -->
                <div class="form-group col-3">
                    <label class="col-xs-4 control-label" for="numClients">Número de invitados: </label>
                    <div class="col-xs-4">
                        <input id="numClients" name="numClients" class="form-control input-md"
                            type="number" min="1">
                    </div>
                </div>
                <!-- Es de noche la reserva? -->
                <div class="form-group col-3">
                    <label class="col-xs-4 control-label" for="selNight">¿Por la noche?: </label>
                    <div class="col-xs-4">
                        <select id="selNight" name="selNight" class="form-control input-md">
                            <option value="">-- Sin filtro --</option>
                            <option value="1">Solo de noche</option>
                            <option value="0">Solo de día</option>
                        </select>
                    </div>
                </div>
            </div>
            <!-- Mesa -->
            <div class="form-group col-12">
                <label class="col-xs-4 control-label" for="selBoard">Mesa: </label>
                <div class="col-xs-4">
                    <select id="selBoard" name="selBoard" class="form-control input-md">
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
<script>
    new SlimSelect({
        select: '#selClient'
    })
    new SlimSelect({
        select: '#selBoard'
    })
</script>
</html>