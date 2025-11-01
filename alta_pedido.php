<?php
require_once("config.php");

$conexion = obtenerConexion();

$sql = "SELECT id_client,name FROM client;";

$resultado = mysqli_query($conexion, $sql);

$options = "";
while ($fila = mysqli_fetch_assoc($resultado)) {
    // $tipos[] = $fila; // Insertar una fila al final
    $options .= " <option value='" . $fila["id_client"] . "'>" . $fila["name"] . "</option>";
}

// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="proceso_alta_cliente.php" name="frmAltaCliente" id="frmAltaCliente" method="post">
            <fieldset>
                <legend>Alta de Pedido</legend>
                <!-- Lista Clientes -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="lstCliente">Cliente</label>
                    <div class="col-xs-4">
                        <select name="lstCliente" id="lstCliente" class="form-select" aria-label="Default select example">
                            <?php echo $options; ?>
                        </select>
                    </div>
                </div>

                <!-- Fecha Reserva -->
                <div class="form-group">
                    <label for="fechaReserva">Selecciona fecha y hora:</label><br>
                    <input type="datetime-local" id="fechaReserva" name="fechaReserva">
                </div>

                <!-- Comentario Pedido -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="textAreaComentario">Comentario</label>
                    <div class="col-xs-4">
                        <textarea name="textAreaComentario" id="textAreaComentario" placeholder="Comentario" cols="30"></textarea>
                    </div>
                    
                </div>

                <!-- Precio Pedido -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="numPrecio">Precio</label>
                    <div class="col-xs-4">
                        <input id="numPrecio" name="numPrecio" placeholder="12.50" class="form-control input-md" type="number" step="0.5" min="0" max="500">
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