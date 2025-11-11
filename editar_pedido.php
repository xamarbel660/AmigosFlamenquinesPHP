<?php

// Recupero datos de parametro en forma de array asociativo
$pedidoEntero = json_decode($_POST['pedido'], true);

require_once("config.php");
$conexion = obtenerConexion();

$sql = "SELECT id_client,name FROM client;";

$resultado = mysqli_query($conexion, $sql);

$options = "";
while ($fila = mysqli_fetch_assoc($resultado)) {
    // Si coincide el tipo con el del componente es el que debe aparecer seleccionado (selected)
    if ($fila['id_client'] == $pedidoEntero['id_client']) {
        $options .= " <option selected value='" . $fila["id_client"] . "'>" . $fila["name"] . "</option>";
    } else {
        $options .= " <option value='" . $fila["id_client"] . "'>" . $fila["name"] . "</option>";
    }
}

$fecha_pedido = new DateTime($pedidoEntero['client_order_date']);
//Le damos el formato 'día/mes/Año' que quieres
$fecha_bien = $fecha_pedido->format('Y-m-d H:i');

// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="proceso_modificar_pedido.php" name="frmAltapedido" id="frmAltapedido" method="post">
            <fieldset>
                <!-- Cliente -->
                <legend>Modificación de Pedido</legend>
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="lstCliente">Cliente</label>
                    <div class="col-xs-4">
                        <select name="lstCliente" id="lstCliente" class="form-select" aria-label="Default select example">
                            <?php echo $options; ?>
                        </select>
                    </div>
                </div>

                <!-- Fecha -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="inpFecha">Fecha</label>
                    <div class="col-xs-4">

                        <input value="<?php echo $fecha_bien ?>" id="inpFecha" name="inpFecha" class="form-control input-md" type="datetime-local">
                    </div>
                </div>

                <!-- Comentario -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtComentario">Comentario</label>
                    <div class="col-xs-4">
                        <input value="<?php echo $pedidoEntero['comment'] ?>" id="txtComentario" name="txtComentario" placeholder="Comentario" class="form-control input-md" type="text">
                    </div>
                </div>

                <!-- Estado -->
                <label class="col-xs-4 control-label" for="txtDescripcion">Estado del pedido</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="estado" id="finalizado" <?php echo ($pedidoEntero["is_completed"] == 1) ? "checked" : "" ?> value="1">
                    <label class="form-check-label" for="finalizado">
                        Finalizado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="estado" id="en_preparacion" <?php echo ($pedidoEntero["is_completed"] == 0) ? "checked" : "" ?> value="0">
                    <label class="form-check-label" for="en_preparacion">
                        En preparación
                    </label>
                </div>


                <!-- Text input-->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="numbPrecioTotal">Precio Total del pedido</label>
                    <div class="col-xs-4">
                        <input value="<?php echo $pedidoEntero['total_price'] ?>" id="numbPrecioTotal" name="numbPrecioTotal" placeholder="Precio" class="form-control input-md" type="number">
                    </div>
                </div>

                <!-- Platos -->
                <div id="platos">

                </div>







                <input value="<?php echo $pedidoEntero['id_client_order'] ?>" type='hidden' name='idPedido' id='idPedido' />
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
<script>
    const bdUrl = "http://127.0.0.1/amigosFlamenquinesPHP/";
    // variable para almacenar los platos seleccionados y sus cantidades
    let platosSeleccionadosData = [];

    async function procesarPlatosSeleccionados() {
    let idPedido = document.querySelector("#idPedido").value;

    let cantidadPlatos = document.querySelector("#cantidadPlatos").value;
    let notaPlato = document.querySelector("#notaPlato").value;


    // Construimos la URL completa
    let oURL = new URL(bdUrl + "proceso_platos_seleccionados.php");

    // Añadimos los parámetros del FormData
    oURL.searchParams.append("idPlatoSeleccionado", idPlatoSeleccionado);

    // Hacemos la petición
    let respuestaServidor = await fetch(oURL, {
        method: "GET"
    });
    let respuestaJSON = await respuestaServidor.json();
    // platoSelec = '<option value="' + respuestaJSON.datos[0].id_plate + '">' + respuestaJSON.datos[0].name + ' - Cantidad: ' + cantidadPlatos + '</option>'; //forma clasica(y sin poner las notas de los platos)
    if (notaPlato.trim() === "") {
        platoSelec = `<option value="${respuestaJSON.datos[0].id_plate}">${cantidadPlatos} ${respuestaJSON.datos[0].name}</option>`;
    } else {
        platoSelec = `<option value="${respuestaJSON.datos[0].id_plate}">${cantidadPlatos} ${respuestaJSON.datos[0].name} (${notaPlato})</option>`;
    }
    // Agregar la nueva opción al select de platos seleccionados
    document.querySelector("#lstPlatosSelect").innerHTML += platoSelec;
    };

    //cuando se pulse en aceptar, preparar los datos para enviarlos
    document.querySelector("#btnAceptarAltaPedido").addEventListener("click",
        function prepararDatosParaEnvio() {
            //añadimos al campo oculto el JSON con los platos seleccionados y sus cantidades
            document.querySelector("#platos_con_cantidad").value = JSON.stringify(platosSeleccionadosData);
        });
</script>
</body>

</html>