<?php
require_once("config.php");

$conexion = obtenerConexion();

$sqlCli = "SELECT id_client,name FROM client;";
$sqlPlat = "SELECT id_plate, name, price FROM plate;";

$resultadoCLi = mysqli_query($conexion, $sqlCli);
$resultadoPlat = mysqli_query($conexion, $sqlPlat);

//Lista de clientes
$clientes = "";
while ($fila = mysqli_fetch_assoc($resultadoCLi)) {
    $clientes .= " <option value='" . $fila["id_client"] . "'>" . $fila["name"] . "</option>";
}

//Lista de platos
$platos = "";
while ($fila = mysqli_fetch_assoc($resultadoPlat)) {
    $platos .= " <option value='" . $fila["id_plate"] . "'>" . $fila["name"] . "__" . $fila["price"] . "€" . "</option>";
}

// Obtenemos la fecha y hora actual
date_default_timezone_set('Europe/Madrid');     //Sin esto, no sale bien la hora
$fechaActual = date("Y-m-d H:i");       //formato de como se guarda en la base de datos

cerrarConexion($conexion);
// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="proceso_alta_pedido.php" name="frmAltaPedido" id="frmAltaPedido" method="POST">
            <fieldset>
                <legend>Alta de Pedido</legend>
                <!-- Lista Clientes -->
                <div class="row mb-2">
                    <label class="col-xs-4 control-label" for="lstCliente">Cliente:</label>
                    <div class="col-xs-4">
                        <select name="lstCliente" id="lstCliente" class="form-select" aria-label="Default select example">
                            <?php echo $clientes; ?>
                        </select>
                    </div>
                </div>

                <!-- Fecha Reserva -->
                <div class="row mb-3">
                    <input type="hidden" id="fechaReserva" name="fechaReserva" value="<?php echo $fechaActual; ?>">
                </div>

                <!-- Comentario Pedido -->
                <div class="row mb-3">
                    <label class="col-xs-4 control-label" for="textAreaComentario">Comentario del pedido:</label>
                    <div class="col-xs-4">
                        <textarea name="textAreaComentario" id="textAreaComentario" placeholder="Comentario" cols="60"></textarea>
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
                        <button class="btn btn-primary rounded-end-2 col-2" type="button" id="añadirPlato" name="añadirPlato">Agregar</button>
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

                        </select>
                    </div>
                </div>

                <input type="hidden" name="platos_con_cantidad" id="platos_con_cantidad">

                <!-- Button -->
                <div class="row mb-3">
                    <label class="col-xs-4 control-label" for="btnAceptarAltaPedido"></label>
                    <div class="col-xs-4">
                        <input type="submit" id="btnAceptarAltaPedido" name="btnAceptarAltaPedido" class="btn bg-secondary" value="Aceptar" />
                    </div>
                </div>

            </fieldset>
        </form>
    </div>
</div>

<script>
    let bdUrl = "http://127.0.0.1/amigosFlamenquinesPHP/";
    // variable para almacenar los platos seleccionados y sus cantidades
    let platosSeleccionadosData = [];

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
    document.querySelector("#btnAceptarAltaPedido").addEventListener("click",
        function prepararDatosParaEnvio() {
            //añadimos al campo oculto el JSON con los platos seleccionados y sus cantidades
            document.querySelector("#platos_con_cantidad").value = JSON.stringify(platosSeleccionadosData);
        });
</script>
</body>

</html>