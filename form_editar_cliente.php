<?php
require_once("config.php");

$conexion = obtenerConexion();

$sqlCat = "SELECT id_category, category_name FROM category;";

$resultadoCat = mysqli_query($conexion, $sqlCat);

$registroCliente = json_decode($_GET['cliente'], true);

$categorias = "";
while ($fila = mysqli_fetch_assoc($resultadoCat)) {
    if(intval($registroCliente['id_category']) == intval($fila["id_category"])){
         $categorias .= " <option value='" . $fila["id_category"] . "' selected>" . htmlspecialchars($fila["category_name"]) . "</option>";
    }else{
        $categorias .= " <option value='" . $fila["id_category"] . "'>" . htmlspecialchars($fila["category_name"]) . "</option>";
    }
}






// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>
<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="editar_cliente.php" name="frmEditarCliente" id="frmEditarCliente"
            method="post">
            <fieldset>
                <!-- Form Name -->
                <legend>Editar un cliente</legend>
                <p class="text-secondary"><?php

                $fecha = implode('-', array_reverse(explode('-', $registroCliente['date_created_account'])));

                echo "Añadido a la base de datos en la fecha: $fecha ";

                ?></p>
                <!-- Text input-->
                <div class="form-group">

                    <p> Id del cliente:
                        <input type="hidden" name="idCliente" value="<?php echo $registroCliente['id_client'] ?>">
                        <?php echo $registroCliente['id_client'] ?>
                    </p>

                </div>
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="nombreCliente">Nombre del cliente: </label>
                    <div class="col-xs-4">
                        <input id="nombreCliente" name="nombreCliente" class="form-control input-md" type="text"
                            value="<?php echo $registroCliente['name'] ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="edadCliente">Edad del cliente: </label>
                    <div class="col-xs-4">
                        <input id="edadCliente" name="edadCliente" class="form-control input-md" type="number" min="16"
                            max="120" value="<?php echo $registroCliente['age'] ?>">
                    </div>
                </div>
                <div class="form-group col-6 col-lg-3">
                        <!-- Categoria cliente -->
                    <div class="form-group">
                        <label for="lstCategorias">Categoria del cliente</label>
                        <select class="form-select col-7 col-md-5" name="lstCategorias" id="lstCategorias" aria-label="Default select example">
                                <?php echo $categorias; ?>
                        </select>
                    </div>
                    <label for="">¿Cliente VIP?</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioVIP" id="radioVIPSi" value="1" <?php if (intval($registroCliente['is_vip']) == 1) {
                            echo 'checked';
                        } ?>>
                        <label class="form-check-label" for="radioVIPSi">
                            Si
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="radioVIP" id="radioVIPNo" value="0" <?php if (intval($registroCliente['is_vip']) == 0) {
                            echo 'checked';
                        } ?>>
                        <label class="form-check-label" for="radioVIPNo">
                            No
                        </label>
                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnAceptarBuscarCliente"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnAceptarBuscarCliente" name="btnAceptarBuscarCliente"
                            class="btn bg-secondary" value="Aceptar" />
                    </div>
                </div>
            </fieldset>
        </form>

    </div>
</div>

</body>

</html>