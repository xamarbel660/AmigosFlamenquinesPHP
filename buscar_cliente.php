<?php
// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="mostrar_listado_cliente_id.php" name="frmBuscarCliente" id="frmBuscarCliente" method="get">
            <fieldset>
                <!-- Form Name -->
                <legend>Buscar un cliente</legend>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="idClienteBuscar">Id del cliente: </label>
                    <div class="col-xs-4">
                        <input id="idClienteBuscar" name="idClienteBuscar" class="form-control input-md" type="number">
                    </div>
                </div>
                
                <!-- Button -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnAceptarBuscarCliente"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnAceptarBuscarCliente" name="btnAceptarBuscarCliente" class="btn bg-secondary" value="Aceptar" />
                    </div>
                </div>
            </fieldset>
        </form>

    </div>
</div>
</body>

</html>