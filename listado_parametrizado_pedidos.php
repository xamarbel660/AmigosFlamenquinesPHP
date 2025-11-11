<?php
// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>
<div class="container" id="formularios">
    <form class="form-horizontal row" action="mostrar_listado_pedidos_parametrizado.php" name="frmListadoParametrizadoPedidos"
        id="frmListadoParametrizadoPedidos" method="get">
        <fieldset>
            <!-- Form Name -->
            <legend>Listado Parametrizado de Pedidos</legend>

            <div class="form-group col-12 mb-2">
                <label class="col-xs-4 control-label" for="nombreCliente">Cliente: </label>
                <div class="col-xs-4">
                    <input id="nombreCliente" name="nombreCliente" class="form-control input-md" type="text"
                        placeholder="Ana Lopez">
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
                    <input type="number" name="inpPrecio" id="inpPrecioMin" value="0" required></input>
                    <br>
                    <label for="">Precio max</label>
                    <input type="number" name="inpPrecio" id="inpPrecioMax" value="700" max="701" required></input>
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