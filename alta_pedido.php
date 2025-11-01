<?php
require_once("config.php");

$conexion = obtenerConexion();

$sql = "SELECT id_client,name FROM client;";
$sql2 = "SELECT id_plate, name, price FROM plate;";

$resultado = mysqli_query($conexion, $sql);
$resultado2 = mysqli_query($conexion, $sql2);


$clientes = "";
while ($fila = mysqli_fetch_assoc($resultado)) {
    $clientes .= " <option value='" . $fila["id_client"] . "'>" . $fila["name"] . "</option>";
}

$platos = "";
while ($fila = mysqli_fetch_assoc($resultado2)) {
    $platos .= " <option value='" . $fila["id_plate"] . "'>" . $fila["name"] . "_________" . $fila["price"] . "€"."</option>";
}

// Obtener fecha y hora actual
date_default_timezone_set('Europe/Madrid');
$fechaActual = date("Y-m-d H:i");

cerrarConexion($conexion);
// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="proceso_alta_pedido.php" name="frmAltaPedido" id="frmAltaPedido" method="post">
            <fieldset>
                <legend>Alta de Pedido</legend>
                <!-- Lista Clientes -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="lstCliente">Cliente:</label>
                    <div class="col-xs-4">
                        <select name="lstCliente" id="lstCliente" class="form-select" aria-label="Default select example">
                            <?php echo $clientes; ?>
                        </select>
                    </div>
                </div>

                <!-- Fecha Reserva -->
                <div class="form-group">
                    <input type="hidden" id="fechaReserva" name="fechaReserva" value="<?php echo $fechaActual; ?>">
                </div>

                <!-- Comentario Pedido -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="textAreaComentario">Comentario:</label>
                    <div class="col-xs-4">
                        <textarea name="textAreaComentario" id="textAreaComentario" placeholder="Comentario" cols="60"></textarea>
                    </div>
                    
                </div>

                <!-- Precio Pedido -->
                <!-- <div class="form-group">
                    <label class="col-xs-4 control-label" for="numPrecio">Precio:</label>
                    <div class="col-xs-4">
                        <input id="numPrecio" name="numPrecio" placeholder="12.50" class="form-control input-md" type="number" step="0.5" min="0" max="500">
                    </div>
                </div> -->
                <!-- Lista Platos -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="lstPlatos">Platos:</label>
                    <div class="col-xs-4">
                        <select name="lstPlatos" id="lstPlatos" class="form-select" multiple aria-label="Default select example">
                            <?php echo $platos; ?>
                        </select>
                    </div>
                </div>
                <!-- Button -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnAceptarAltaPedido"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnAceptarAltaPedido" name="btnAceptarAltaPedido" class="btn bg-secondary" value="Aceptar" />
                    </div>
                </div>
            </fieldset>
        </form>

    </div>
</div>
</body>

</html>