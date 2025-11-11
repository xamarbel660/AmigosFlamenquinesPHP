<?php
include_once("config.php");

$conexion = obtenerConexion();

// Cabecera HTML que incluye navbar
include_once("form_listado_parametrizado_pedidos.php");

$sql = "SELECT * FROM client_order o, client c WHERE o.id_client = c.id_client ";


if (isset($_GET["nombreCliente"])) {
    $nombreCliente = $_GET["nombreCliente"];
    $sql .= "AND c.name LIKE '%$nombreCliente%' ";
}
if (isset($_GET["fechaPedido"])) {
    $fechaPedido = $_GET["fechaPedido"];
    $sql .= "AND o.client_order_date = '$fechaPedido' ";
}
if (isset($_GET["estado"])) {
    $estado = $_GET["estado"];
    $sql .= "AND is_completed = $estado ";
}
if (isset($_GET["inpPrecioMin"]) && isset($_GET["inpPrecioMax"])) {
    $precioMin = $_GET["inpPrecioMin"];
    $precioMax = $_GET["inpPrecioMax"];
    $sql .= "AND o.total_price BETWEEN $precioMin AND $precioMax";
}

$sql .= ";";


$tabla = "<table class='table table-striped text-center mt-3' id='listadoClientes'>";
$tabla .= "<thead><tr><th>Cliente</th><th>total_price</th><th>is_completed</th><th>client_order_date</th>";

$resultado = mysqli_query($conexion, $sql);

$tabla .= "</tr></thead><tbody>";
while ($fila = mysqli_fetch_assoc($resultado)) {
    $tabla .= "<tr>";
    $tabla .= "<td>" . $fila["name"] . "</td>";
    $tabla .= "<td>" . $fila["total_price"] . "</td>";
    $tabla .= "<td>" . ($fila["is_completed"]==1 ? "Finalizado" : "En preparación") . "</td>";
    $fecha = implode('-', array_reverse(explode('-', $fila['client_order_date'])));
    $tabla .= "<td>" . $fecha . "</td>";
    $tabla .= "</tr>";
}
$tabla .= "</tbody></table>";

?>
<?php
echo $tabla;
?>
</body>

</html>