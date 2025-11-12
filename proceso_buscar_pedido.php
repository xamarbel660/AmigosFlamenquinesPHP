<?php
require_once("config.php");
$conexion = obtenerConexion();

if (isset($_GET['txtNombreCliente'])) {
    // Recuperar parámetro
    $nombre_cliente = $_GET['txtNombreCliente'];

    // No validamos, suponemos que la entrada de datos es correcta

    $sql = "SELECT o.*, c.name FROM client_order o, client c 
        WHERE o.id_client = c.id_client 
        AND c.name LIKE '%$nombre_cliente%';";

    $resultado = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($resultado) > 0) { // Comprobamos que la tabla no este vacía

        $tabla = "<h2 class='text-center'>Pedidos localizados</h2>";
        $tabla .= "<table class='table table-striped text-center mt-3' id='listadoPedidos'>";
        $tabla .= "<thead><tr><th>Cliente</th><th>FECHA PEDIDO</th><th>COMENTARIO</th><th>ESTADO</th><th>PRECIO TOTAL</th>";
        $tabla .= "</tr></thead><tbody>";

        while ($fila = mysqli_fetch_assoc($resultado)) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $fila['name'] . "</td>";
            //Creamos un objeto de Fecha con el valor que viene de la base de datos
            $fecha_pedido = new DateTime($fila['client_order_date']);
            //Le damos el formato 'día/mes/Año' que quieres
            $tabla .= "<td>" . $fecha_pedido->format('d/m/Y') . "</td>";
            // $mensaje .= "<td>" . $fila['client_order_date'] . "</td>";
            $tabla .= "<td>" . $fila['comment'] . "</td>";
            $tabla .= "<td>" . (($fila['is_completed'] == 0) ? "En proceso" : "Finalizado") . "</td>";
            $tabla .= "<td>" . $fila['total_price'] . "</td>";

            // Formulario en la celda para procesar borrado del registro
            // input hidden para enviar idcomponente a borrar
            $tabla .= "<td><form class='d-inline me-1' action='editar_pedido.php' method='post'>";
            $tabla .= "<input type='hidden' name='pedido' value='" . htmlspecialchars(json_encode($fila), ENT_QUOTES) . "' />";
            $tabla .= "<button name='Editar' class='btn btn-primary'><i class='bi bi-pencil-square'></i></button></form>";

            $tabla .= "<form class='d-inline' action='proceso_borrar_pedido.php' method='post'>";
            $tabla .= "<input type='hidden' name='id_client_order' value='" . $fila['id_client_order']  . "' />";
            $tabla .= "<button name='Borrar' class='btn btn-danger'><i class='bi bi-trash'></i></button></form>";

            $tabla .= "</tr>";
        }

        $tabla .= "</tbody></table>";
    } else { // No hay datos
        $tabla = "<h2 class='text-center mt-5'>No hay pedidos con nombre $nombre_cliente</h2>";
        header("refresh:5;url=buscar_pedido.php");
    }
} else {
    $sql = "SELECT * FROM client_order o, client c WHERE o.id_client = c.id_client ";

    $idCliente = $_GET["lstClientes"];
    if ($idCliente != 0) {
        $sql .= "AND c.id_client = $idCliente ";
    }

    if (!empty($_GET["fechaPedido"])) {
        $fechaPedido = $_GET["fechaPedido"];
        $sql .= "AND o.client_order_date = '$fechaPedido' ";
    }
    if (isset($_GET["estado"])) {
        $estado = $_GET["estado"];
        $sql .= "AND is_completed = $estado ";
    }
    if ((isset($_GET["inpPrecioMin"]) && isset($_GET["inpPrecioMax"])) && (!empty($_GET["inpPrecioMin"]) && !empty($_GET["inpPrecioMax"]))) {
        $precioMin = $_GET["inpPrecioMin"];
        $precioMax = $_GET["inpPrecioMax"];

        $sql .= "AND  o.total_price >= $precioMin AND o.total_price <= $precioMax ";
    } elseif ((isset($_GET["inpPrecioMin"])) && (!empty($_GET["inpPrecioMin"]))) {
        $precioMin = $_GET["inpPrecioMin"];
        $sql .= "AND  o.total_price >= $precioMin ";
    } elseif ((isset($_GET["inpPrecioMax"])) && (!empty($_GET["inpPrecioMax"]))) {
        $precioMax = $_GET["inpPrecioMax"];
        $sql .= "AND  o.total_price <= $precioMax ";
    }

    $sql .= ";";

    $tabla = "<h2 class='text-center'>Pedidos localizados</h2>";
    $tabla .= "<table class='table table-striped text-center mt-3' id='listadoPedidosParametrizado'>";
    $tabla .= "<thead><tr><th>Cliente</th><th>FECHA PEDIDO</th><th>COMENTARIO</th><th>ESTADO</th><th>PRECIO TOTAL</th>";

    $resultado = mysqli_query($conexion, $sql);

    $tabla .= "</tr></thead><tbody>";
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $tabla .= "<tr>";
        $tabla .= "<td>" . $fila["name"] . "</td>";
        //Creamos un objeto de Fecha con el valor que viene de la base de datos
        $fecha_pedido = new DateTime($fila['client_order_date']);
        //Le damos el formato 'día/mes/Año' que quieres
        $tabla .= "<td>" . $fecha_pedido->format('d/m/Y') . "</td>";
        $tabla .= "<td>" . $fila["comment"] . "</td>";
        $tabla .= "<td>" . ($fila["is_completed"] == 1 ? "Finalizado" : "En preparación") . "</td>";
        $tabla .= "<td>" . $fila["total_price"] . "</td>";

        $tabla .= "<td><form class='d-inline me-1' action='editar_pedido.php' method='post'>";
        $tabla .= "<input type='hidden' name='pedido' value='" . htmlspecialchars(json_encode($fila), ENT_QUOTES) . "' />";
        $tabla .= "<button name='Editar' class='btn btn-primary'><i class='bi bi-pencil-square'></i></button></form>";

        $tabla .= "<form class='d-inline' action='proceso_borrar_pedido.php' method='post'>";
        $tabla .= "<input type='hidden' name='id_client_order' value='" . $fila['id_client_order']  . "' />";
        $tabla .= "<button name='Borrar' class='btn btn-danger'><i class='bi bi-trash'></i></button></form>";

        $tabla .= "</tr>";
    }
    $tabla .= "</tbody></table>";
}

// Insertamos cabecera
include_once("cabecera.html");

// Mostrar mensaje calculado antes
echo $tabla;

?>
</body>

</html>