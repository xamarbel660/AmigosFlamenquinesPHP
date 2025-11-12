<?php
require_once("config.php");

$conexion = obtenerConexion();

$sqlCli = "SELECT id_client,name FROM client;";

$resultadoCLi = mysqli_query($conexion, $sqlCli);

//Lista de clientes
$clientes = "";
while ($fila = mysqli_fetch_assoc($resultadoCLi)) {
    $clientes .= " <option value='" . $fila["id_client"] . "'>" . $fila["name"] . "</option>";
}
// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>
<div class="container" id="formularios">
    <form class="form-horizontal row" action="proceso_buscar_pedido.php" name="frmListadoParametrizadoPedidos"
        id="frmListadoParametrizadoPedidos" method="get">
        <fieldset>
            <!-- Form Name -->
            <legend>Listado Parametrizado de Pedidos</legend>

            <div class="form-group col-12 mb-2">
                <label class="col-xs-4 control-label" for="nombreCliente">Cliente: </label>
                <div class="col-xs-4">
                    <select class="form-select col-7 col-md-5" name="lstClientes" id="lstClientes" aria-label="Default select example">
                        <option value="0">Selecione un cliente</option>
                        <?php echo $clientes; ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-12 mb-2">
                <label class="col-xs-4 control-label" for="fechaPedido">Fecha del pedido: </label>
                <div class="col-xs-4">
                    <input id="fechaPedido" name="fechaPedido" class="form-control input-md" type="datetime-local">
                </div>
            </div>

            <!-- Estado -->
            <label class="col-xs-4 control-label" for="estado">Estado del pedido</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="estado" id="finalizado" value="1">
                <label class="form-check-label" for="finalizado">
                    Finalizado
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="estado" id="en_preparacion" value="0">
                <label class="form-check-label" for="en_preparacion">
                    En preparación
                </label>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label" for="inpPrecio">Rango de precios</label>
                <div class="col-xs-4">
                    <label for="">Precio min</label>
                    <input type="number" name="inpPrecioMin" id="inpPrecioMin" placeholder="0" min="0" step="0.5"></input>
                    <br>
                    <label for="">Precio max</label>
                    <input type="number" name="inpPrecioMax" id="inpPrecioMax" placeholder="700" max="700" step="0.5"></input>
                </div>
            </div>

            <!-- Button -->
            <div class="form-group">
                <label class="col-xs-4 control-label" for="btnAceptarBuscarCliente"></label>
                <div class="col-xs-4">
                    <input type="submit" id="btnAceptarListadoParametrizado" name="btnAceptarListadoParametrizado"
                        class="btn bg-secondary" value="Aceptar" />
                </div>
            </div>
        </fieldset>
    </form>
</div>