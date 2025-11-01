<?php

// Recupero datos de parametro en forma de array asociativo
$componente = json_decode($_GET['tipo'],true);

require_once("config.php");
$conexion = obtenerConexion();

$sql = "SELECT idtipo,tipo FROM tipo;";

$resultado = mysqli_query($conexion, $sql);

$options = "";
while ($fila = mysqli_fetch_assoc($resultado)) {
    // Si coincide el tipo con el del componente es el que debe aparecer seleccionado (selected)
    if ($fila['idtipo'] == $componente['idtipo']){
        $options .= " <option selected value='" . $fila["idtipo"] . "'>" . $fila["tipo"] . "</option>";
    } else{
        $options .= " <option value='" . $fila["idtipo"] . "'>" . $fila["tipo"] . "</option>";
    }
}

// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="proceso_modificar_tipo.php" name="frmAltacomponente" id="frmAltacomponente" method="post">
            <fieldset>
                <!-- Form Name -->
                <legend>Modificación de tipo</legend>
                <!-- Number input-->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="numTipo">IdTipo</label>
                    <div class="col-xs-4">
                        <input value="<?php echo $componente['idtipo']?>" id="numTipo" name="numTipo" placeholder="Id del tipo" class="form-control input-md" type="hidden">
                        <input value="<?php echo $componente['idtipo']?>" id="numTipo" name="numTipo" placeholder="Id del tipo" class="form-control input-md" type="number" disabled>
                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtTipo">Tipo</label>
                    <div class="col-xs-4">
                        <input value="<?php echo $componente['tipo']?>" id="txtTipo" name="txtTipo" placeholder="Tipo" class="form-control input-md" type="text">
                    </div>
                </div>
                
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtDescripcion">Descripción</label>
                    <div class="col-xs-4">
                        <input value="<?php echo $componente['descripcion']?>" id="txtDescripcion" name="txtDescripcion" placeholder="Descripcion" class="form-control input-md" type="text">
                    </div>
                </div>
                <!-- Button -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnAceptarAltaComponente"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnAceptarAltaComponente" name="btnAceptarAltaComponente" class="btn btn-primary" value="Aceptar" />
                    </div>
                </div>
            </fieldset>
        </form>

    </div>
</div>
</body>

</html>