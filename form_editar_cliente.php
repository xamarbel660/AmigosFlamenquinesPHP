<?php
include_once("config.php");


$conexion = obtenerConexion();

$registroCliente = json_decode($_GET['cliente'],true);
    



// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>
    <div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="mostrar_listado_cliente_id.php" name="frmBuscarCliente" id="frmBuscarCliente" method="get">
            <fieldset>
                <!-- Form Name -->
                <legend>Editar un cliente</legend>
                <p class="text-secondary"><?php 
                
                    $fecha = implode('-',array_reverse(explode('-',$registroCliente['date_created_account'])));
                    
                    echo "Añadido a la base de datos en la fecha: $fecha "; 
                    
                ?></p>
                <!-- Text input-->
                <div class="form-group">
                    
                    <p name="idCliente"> Id del cliente:
                        <?php echo $registroCliente['id_client']  ?>
                    </p>
        
                </div>
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="idClienteBuscar">Nombre del cliente: </label>
                    <div class="col-xs-4">
                        <input id="idCliente" name="idCliente" class="form-control input-md" type="text" value="<?php echo $registroCliente['name']  ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="idClienteBuscar">Edad del cliente: </label>
                    <div class="col-xs-4">
                        <input id="edadCliente" name="edadCliente" class="form-control input-md"
                        type="number" min="16" max="120" value="<?php echo $registroCliente['age']  ?>">
                    </div>
                </div>
                <div class="form-group col-3">
                    <label for="">¿Cliente VIP?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioVIP" id="radioVIPSi" value="1" <?php if (intval($registroCliente['is_vip']) == 1) {echo 'checked';} ?>>
                        <label class="form-check-label" for="radioVIPSi">
                            Si
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioVIP" id="radioVIPNo" value="0" <?php if (intval($registroCliente['is_vip']) == 0) {echo 'checked';} ?>>
                        <label class="form-check-label" for="radioVIPNo">
                            No
                        </label>
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
    
</body>

</html>