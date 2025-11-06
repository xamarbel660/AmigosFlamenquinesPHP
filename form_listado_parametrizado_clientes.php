<?php
include_once("config.php");


$conexion = obtenerConexion();



// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>
<div class="container" id="formularios">
    <form class="form-horizontal row" action="mostrar_listado_clientes_parametrizado.php" name="frmListadoParametrizadoClientes"
        id="frmListadoParametrizadoClientes" method="get">
        <fieldset>
            <!-- Form Name -->
            <legend>Listado Parametrizado de Clientes</legend>

            <div class="form-group col-12 mb-2">
                <label class="col-xs-4 control-label" for="nombreCliente">Nombre del cliente: </label>
                <div class="col-xs-4">
                    <input id="nombreCliente" name="nombreCliente" class="form-control input-md" type="text"
                        placeholder="Escribe aquí su nombre o parte de él...">
                </div>
            </div>

            <div class="form-group col-12 mb-2">
                <label class="col-xs-4 control-label" for="nombreCliente">Fecha añadido: </label>
                <div class="col-xs-4">
                    <input id="fechaAnyadido" name="fechaAnyadido" class="form-control input-md" type="date">
                </div>
            </div>

            <div class="row col-12 mb-2">
                <div class="form-group col-6">
                    <label class="col-xs-4 control-label" for="edadCliente">Edad del cliente: </label>
                    <div class="col-xs-4">
                        <input id="edadCliente" name="edadCliente" class="form-control input-md" type="number" min="16"
                            max="120">
                    </div>
                </div>
                <div class="form-group col-6">
                    <label for="">¿Cliente VIP?</label>
                    <div class="col-xs-4">
                        <select name="lstEsVip" id="lstEsVip" class="form-select" aria-label="Default select example">
                            <option value="-1" selected>Elige una opcion</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
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