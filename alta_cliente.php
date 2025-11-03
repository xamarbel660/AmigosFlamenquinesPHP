<?php
// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <form class="form-horizontal" action="proceso_alta_cliente.php" name="frmAltaCliente" id="frmAltaCliente"
        method="post">
        <fieldset class="row ">
            <legend>Alta de cliente</legend>
            <!-- Nombre del cliente -->
            <div class="form-group col-12">
                <label class="col-xs-4 control-label" for="nombreCliente">Nombre: </label>
                <div class="col-xs-4">
                    <input id="nombreCliente" name="nombreCliente" placeholder="Escribe aquí el nombre del cliente..."
                        class="form-control input-md" type="text">
                </div>
            </div>

            <div class="row justify-content-between my-4 ">
                <!-- Edad del cliente -->
                <div class="form-group col-3">
                    <label class="col-xs-4 control-label" for="edadCliente">Edad: </label>
                    <div class="col-xs-4">
                        <input id="edadCliente" name="edadCliente" value="18" class="form-control input-md"
                            type="number" min="16" max="120">
                    </div>
                </div>

                <!-- Radio VIP -->
                <div class="form-group col-3">
                    <label for="">¿Cliente VIP?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioVIP" id="radioVIPSi " value="1">
                        <label class="form-check-label" for="radioVIPSi">
                            Si
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioVIP" id="radioVIPNo" value="0" checked>
                        <label class="form-check-label" for="radioVIPNo">
                            No
                        </label>
                    </div>
                </div>
            </div>
            <!-- Button -->
            <div class="form-group">
                <label class="col-xs-4 control-label" for="btnAceptarAltaCliente"></label>
                <div class="col-xs-4">
                    <input type="submit" id="btnAceptarAltaCliente" name="btnAceptarAltaCliente"
                        class="btn bg-secondary" value="Aceptar" />
                </div>
            </div>
        </fieldset>
    </form>
</div>
</body>

</html>