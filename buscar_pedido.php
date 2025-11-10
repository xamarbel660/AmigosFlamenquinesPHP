<?php
// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="proceso_buscar_pedido.php" name="frmBuscarPedido" id="frmBuscarPedido" method="get">
            <fieldset>
                <!-- Form Name -->
                <legend>Buscar un Pedido</legend>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtNombreCliente">Nombre del Cliente</label>
                    <div class="col-xs-4">
                        <input id="txtNombreCliente" name="txtNombreCliente" placeholder="Ana López" class="form-control input-md" type="text">
                    </div>
                </div>
                
                <!-- Button -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnAceptarBuscarPedido"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnAceptarBuscarPedido" name="btnAceptarBuscarPedido" class="btn btn-primary" value="Aceptar" />
                    </div>
                </div>
            </fieldset>
        </form>

    </div>
</div>
</body>

</html>