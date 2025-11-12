<?php
// Recupero datos de parametro en forma de array asociativo
$pedidoEntero = json_decode($_POST['pedido'], true);

require_once("config.php");
$conexion = obtenerConexion();

$sql = "SELECT id_client,name FROM client;";

$resultado = mysqli_query($conexion, $sql);

$clientes = "";
while ($fila = mysqli_fetch_assoc($resultado)) {
    // Si coincide el tipo con el del componente es el que debe aparecer seleccionado (selected)
    if ($fila['id_client'] == $pedidoEntero['id_client']) {
        $clientes .= " <option selected value='" . $fila["id_client"] . "'>" . $fila["name"] . "</option>";
    } else {
        $clientes .= " <option value='" . $fila["id_client"] . "'>" . $fila["name"] . "</option>";
    }
}

$fecha_pedido = new DateTime($pedidoEntero['client_order_date']);
//Le damos el formato 'día/mes/Año' que quieres
$fecha_bien = $fecha_pedido->format('Y-m-d H:i');

$sqlPlat = "SELECT id_plate, name, price FROM plate;";
$resultadoPlat = mysqli_query($conexion, $sqlPlat);

//Lista de platos
$platos = "";
while ($fila = mysqli_fetch_assoc($resultadoPlat)) {
    $platos .= " <option value='" . $fila["id_plate"] . "'>" . $fila["name"] . "__" . $fila["price"] . "€" . "</option>";
}

$sqlPlatSel = "SELECT 
  p.id_plate,
  p.name,
  p.price,
  p.added_date,
  p.is_available,
  od.id_client_order,
  od.quantity,
  od.notes
FROM plate p 
JOIN order_dish od ON p.id_plate = od.id_plate
WHERE od.id_client_order = " . $pedidoEntero["id_client_order"] . ";";
$resultadoPlatSel = mysqli_query($conexion, $sqlPlatSel);
$platosArray = [];

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
                            <?php echo $clientes; ?>
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

                <!-- Lista Platos -->
                <div class="row mb-3">
                    <label class="col-12 control-label" for="lstPlatos">Platos:</label>
                    <div class="col-12 input-group mb-3">
                        <select class="form-select col-7 col-md-5" name="lstPlatos" id="lstPlatos" aria-label="Default select example">
                            <?php echo $platos; ?>
                        </select>
                        <!-- Cantidad de platos -->
                        <input class="col-2 border-end-0" type="number" name="cantidadPlatos" id="cantidadPlatos" min="1" max="20" value="1">
                        <!-- Cantidad de platos -->
                        <button class="btn rounded-end-2 col-2 bg-secondary" type="button" id="añadirPlato" name="añadirPlato">Agregar</button>
                        <!-- Label para poder que ocupe el espacio necesario para que quede bien -->
                        <div class="col-1 col-md-3">
                            <label for=""></label>
                        </div>
                    </div>
                    <div class="col-12 input-group mb-3">
                        <label class="col-12 control-label" for="notaPlato">Nota </label>
                        <textarea placeholder="Sin mucha sal" id="notaPlato" cols="40"></textarea>
                    </div>
                </div>

                <!-- Lista Platos Selecionadas-->
                <div class="row mb-3">
                    <label class="col-xs-4 control-label" for="lstPlatosSelect">Platos Selecionados:</label>
                    <div class="col-xs-4">
                        <select name="lstPlatosSelect" id="lstPlatosSelect" class="form-select" multiple aria-label="Default select example">
                            <?php while ($fila = mysqli_fetch_assoc($resultadoPlatSel)): ?>
                                <?php $platosArray[] = [
                                    "idPlato" => $fila["id_plate"],
                                    "cantidad" => $fila["quantity"],
                                    "nota" => $fila["notes"]
                                ]; ?>
                                <option value=<?=$fila["id_plate"]?>><?=$fila["quantity"]?> <?=$fila["name"]?> <?=$fila["notes"] !== "" ? " (".$fila["notes"].")" : ""?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="platos_con_cantidad" id="platos_con_cantidad">

                <input value="<?php echo $pedidoEntero['id_client_order'] ?>" type='hidden' name='idPedido' id='idPedido' />
                <!-- Button -->
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="btnAceptarEditarPedido"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnAceptarEditarPedido" name="btnAceptarEditarPedido" class="btn btn-primary" value="Aceptar" />
                    </div>
                </div>
            </fieldset>
        </form>

    </div>
</div>
<script>
    let bdUrl = "http://127.0.0.1/amigosFlamenquinesPHP/";
    // variable para almacenar los platos seleccionados y sus cantidades
    let platosSeleccionadosData = <?= json_encode($platosArray, JSON_UNESCAPED_UNICODE) ?>;

    document.querySelector("#añadirPlato").addEventListener('click',
        async function procesarPlatosSeleccionados() {
            let idPlatoSeleccionado = document.querySelector("#lstPlatos").value;
            let cantidadPlatos = document.querySelector("#cantidadPlatos").value;
            let notaPlato = document.querySelector("#notaPlato").value;

            platosSeleccionadosData.push({
                idPlato: idPlatoSeleccionado,
                cantidad: cantidadPlatos,
                nota: notaPlato
            });

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
            if(notaPlato.trim() === ""){
                platoSelec = `<option value="${respuestaJSON.datos[0].id_plate}">${cantidadPlatos} ${respuestaJSON.datos[0].name}</option>`;
            }else{
                platoSelec = `<option value="${respuestaJSON.datos[0].id_plate}">${cantidadPlatos} ${respuestaJSON.datos[0].name} (${notaPlato})</option>`;
            }
            // Agregar la nueva opción al select de platos seleccionados
            document.querySelector("#lstPlatosSelect").innerHTML += platoSelec;
    });

    //cuando se pulse en aceptar, preparar los datos para enviarlos
    document.querySelector("#btnAceptarEditarPedido").addEventListener("click",
        function prepararDatosParaEnvio() {
            //añadimos al campo oculto el JSON con los platos seleccionados y sus cantidades
            document.querySelector("#platos_con_cantidad").value = JSON.stringify(platosSeleccionadosData);
    });
</script>
</body>

</html>