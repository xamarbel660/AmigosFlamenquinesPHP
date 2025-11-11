<?php

// Recupero datos de parametro en forma de array asociativo
$pedidoEntero = json_decode($_POST['pedido'], true);

require_once("config.php");
$conexion = obtenerConexion(); //

// --- NUEVO ---
// Necesitamos cargar TODOS los platos disponibles para el dropdown de "Añadir Plato"
// (Este código es copiado de tu alta_pedido.php)
$sqlPlat = "SELECT id_plate, name, price FROM plate;";
$resultadoPlat = mysqli_query($conexion, $sqlPlat);
$platos_options = ""; // Lo llamamos diferente para no confundir
while ($fila = mysqli_fetch_assoc($resultadoPlat)) {
    $platos_options .= " <option value='" . $fila["id_plate"] . "'>" . $fila["name"] . "__" . $fila["price"] . "€" . "</option>";
}
// --- FIN NUEVO ---


// Este código ya lo tenías: Cargar los clientes
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

// Este código ya lo tenías: Formatear la fecha
$fecha_pedido = new DateTime($pedidoEntero['client_order_date']);
$fecha_bien = $fecha_pedido->format('Y-m-d H:i'); // Formato para el input datetime-local

// Cabecera HTML que incluye navbar
include_once("cabecera.html"); //
?>

<div class="container" id="formularios">
    <div class="row">
        <form class="form-horizontal" action="proceso_modificar_pedido.php" name="frmAltapedido" id="frmAltapedido" method="post">

            <input type="hidden" name="idPedido" id="idPedido" value="<?php echo $pedidoEntero['id_client_order']; ?>" />

            <input type="hidden" name="platos_con_cantidad" id="platos_con_cantidad">
            <fieldset>
                <legend>Editar Pedido (ID: <?php echo $pedidoEntero['id_client_order']; ?>)</legend>

                <div class="form-group">
                    <label class="col-xs-4 control-label" for="lstCliente">Cliente</label>
                    <div class="col-xs-4">
                        <select id="lstCliente" name="lstCliente" class="form-control">
                            <?php echo $options; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-4 control-label" for="fechaReserva">Fecha y Hora</label>
                    <div class="col-xs-4">
                        <input id="fechaReserva" name="fechaReserva" type="datetime-local" class="form-control input-md" value="<?php echo $fecha_bien; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-4 control-label" for="txtComentario">Comentario</label>
                    <div class="col-xs-4">
                        <textarea class="form-control" id="txtComentario" name="txtComentario"><?php echo $pedidoEntero['comment']; ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-4 control-label" for="estado">Estado</label>
                    <div class="col-xs-4">
                        <select id="estado" name="estado" class="form-control">
                            <option value="0" <?php echo ($pedidoEntero['is_completed'] == 0) ? "selected" : ""; ?>>En proceso</option>
                            <option value="1" <?php echo ($pedidoEntero['is_completed'] == 1) ? "selected" : ""; ?>>Finalizado</option>
                        </select>
                    </div>
                </div>

            </fieldset>

            <fieldset>
                <legend>Platos Actuales</legend>
                <div class="form-group">
                    <ul id="lista_platos_actuales" class="list-group col-xs-6">
                        <li class="list-group-item">Cargando platos...</li>
                    </ul>
                </div>
            </fieldset>

            <fieldset>
                <legend>Añadir Platos Nuevos</legend>
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="lstPlatos">Platos</label>
                    <div class="col-xs-4">
                        <select id="lstPlatos" name="lstPlatos" class="form-control">
                            <?php echo $platos_options; ?> </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="cantidadPlatos">Cantidad</label>
                    <div class="col-xs-4">
                        <input id="cantidadPlatos" name="cantidadPlatos" type="number" value="1" min="1" class="form-control input-md">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="notaPlato">Nota (opcional)</label>
                    <div class="col-xs-4">
                        <input id="notaPlato" name="notaPlato" type="text" placeholder="Sin cebolla, etc." class="form-control input-md">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-4 control-label" for="añadirPlato"></label>
                    <div class="col-xs-4">
                        <button type="button" id="añadirPlato" name="añadirPlato" class="btn btn-info">Añadir Plato al Pedido</button>
                    </div>
                </div>
            </fieldset>
            <div class="form-group">
                <label class="col-xs-4 control-label" for="btnAceptarAltaComponente"></label>
                <div class="col-xs-4">
                    <input type="submit" id="btnAceptarAltaComponente" name="btnAceptarAltaComponente" class="btn btn-primary" value="Guardar Cambios" />
                </div>
            </div>

        </form>

    </div>
</div>

<script>
    let bdUrl = "http://127.0.0.1/amigosFlamenquinesPHP/";

    // --- ¡LA CLAVE ESTÁ AQUÍ! ---
    // Array global que guarda el estado de los platos del pedido
    // Contendrá objetos: { idPlato: "1", cantidad: "2", nota: "Sin picante", nombre: "Plato 1" }
    let platosDelPedidoData = [];

    // --- Referencias a los elementos HTML ---
    // De la sección "Añadir Plato"
    const selectPlatosDisponibles = document.querySelector("#lstPlatos");
    const inputCantidad = document.querySelector("#cantidadPlatos");
    const inputNota = document.querySelector("#notaPlato");
    const btnAnadirPlato = document.querySelector("#añadirPlato");

    // Contenedor donde pintamos la lista de platos actuales
    const contenedorLista = document.querySelector("#lista_platos_actuales");

    // --- 1. FUNCIÓN PARA PINTAR LA LISTA ---
    // Esta función lee el array "platosDelPedidoData" y lo dibuja en el HTML
    function renderListaPlatos() {
        contenedorLista.innerHTML = ""; // Limpiamos la lista

        if (platosDelPedidoData.length === 0) {
            contenedorLista.innerHTML = "<li class='list-group-item'>No hay platos en el pedido.</li>";
            return;
        }

        // Recorremos el array y creamos un <li> por cada plato
        platosDelPedidoData.forEach((plato, index) => {
            let notaTexto = plato.nota ? ` (${plato.nota})` : ""; // Muestra la nota si existe
            let itemHTML = `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${plato.cantidad} x ${plato.nombre}</strong>
                        <small class="d-block">${notaTexto}</small>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm" onclick="quitarPlato(${index})">
                        Quitar
                    </button>
                </li>
            `;
            contenedorLista.innerHTML += itemHTML;
        });
    }

    // --- 2. FUNCIÓN PARA QUITAR UN PLATO ---
    // Se llama desde el botón "Quitar"
    function quitarPlato(index) {
        // Confirmación para evitar accidentes
        if (confirm("¿Seguro que quieres quitar este plato?")) {
            platosDelPedidoData.splice(index, 1); // Elimina el plato del array
            renderListaPlatos(); // Vuelve a pintar la lista
        }
    }

    // --- 3. FUNCIÓN PARA AÑADIR UN PLATO ---
    // Se llama desde el botón "Añadir Plato al Pedido"
    async function anadirPlatoClick() {
        const idPlato = selectPlatosDisponibles.value;
        const cantidad = inputCantidad.value;
        const nota = inputNota.value.trim(); // .trim() quita espacios en blanco

        // Necesitamos el nombre del plato, lo buscamos con un fetch
        // (Usamos proceso_platos_seleccionados, que arreglaremos luego)
        let oURL = new URL(bdUrl + "proceso_platos_seleccionados.php"); //
        oURL.searchParams.append("idPlatoSeleccionado", idPlato);

        let respuestaServidor = await fetch(oURL, {
            method: "GET"
        });
        let respuestaJSON = await respuestaServidor.json();
        const nombrePlato = respuestaJSON.datos[0].name;

        // Añadimos el plato nuevo al array
        platosDelPedidoData.push({
            idPlato: idPlato,
            cantidad: cantidad,
            nota: nota,
            nombre: nombrePlato // Guardamos el nombre para poder pintarlo
        });

        renderListaPlatos(); // Vuelve a pintar la lista

        // Limpiamos los campos de añadir
        inputCantidad.value = 1;
        inputNota.value = "";
    }

    // --- 4. FUNCIÓN PARA CARGAR LOS DATOS INICIALES ---
    // Se llama al cargar la página. Carga los platos que YA están en el pedido.
    async function cargarPlatosActuales() {
        let idPedido = document.querySelector("#idPedido").value;
        let oURL = new URL(bdUrl + "proceso_platos_seleccionados.php"); //
        oURL.searchParams.append("idDelPedido", idPedido);

        let respuestaServidor = await fetch(oURL, {
            method: "GET"
        });
        let respuestaJSON = await respuestaServidor.json();

        // Vaciamos el array y lo rellenamos con los datos del servidor
        platosDelPedidoData = [];
        respuestaJSON.datos.forEach(plato => {
            platosDelPedidoData.push({
                idPlato: plato.id_plate, // ¡Necesitamos que 'proceso_platos_seleccionados' nos dé el ID!
                cantidad: plato.quantity,
                nota: plato.notes,
                nombre: plato.name
            });
        });

        renderListaPlatos(); // Pintamos la lista por primera vez
    }

    // --- 5. PREPARAR EL ENVÍO DEL FORMULARIO ---
    // Se llama cuando pulsas "Guardar Cambios" (el botón submit)
    document.querySelector("#frmAltapedido").addEventListener("submit", function(event) {

        // Convertimos nuestro array 'platosDelPedidoData' en un texto JSON
        const jsonPlatos = JSON.stringify(platosDelPedidoData);

        // Metemos ese texto JSON en el campo oculto
        document.querySelector("#platos_con_cantidad").value = jsonPlatos;

        // El formulario se envía normalmente...
    });

    // --- 6. ASIGNAR EVENTOS Y CARGAR DATOS ---

    // Asignamos la función 'anadirPlatoClick' al botón de añadir
    btnAnadirPlato.addEventListener("click", anadirPlatoClick);

    // Cargamos los platos del pedido en cuanto se carga la página
    cargarPlatosActuales();
</script>

</body>

</html>