<?php
include_once("config.php");

$conexion = obtenerConexion();

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
if ((isset($_GET["inpPrecioMin"]) && isset($_GET["inpPrecioMax"]))&&(!empty($_GET["inpPrecioMin"]) && !empty($_GET["inpPrecioMax"]))) {
    $precioMin = $_GET["inpPrecioMin"];
    $precioMax = $_GET["inpPrecioMax"];
    //$sql .= "AND ";
    $sql .= "AND  o.total_price >= $precioMin AND o.total_price <= $precioMax ";
}

$sql .= ";";

echo "SQL: " . $sql . "<br>";
$tabla = "<table class='table table-striped text-center mt-3' id='listadoClientes'>";
$tabla .= "<thead><tr><th>Cliente</th><th>total_price</th><th>is_completed</th><th>client_order_date</th>";

$resultado = mysqli_query($conexion, $sql);

$tabla .= "</tr></thead><tbody>";
while ($fila = mysqli_fetch_assoc($resultado)) {
    $tabla .= "<tr>";
    $tabla .= "<td>" . $fila["name"] . "</td>";
    $tabla .= "<td>" . $fila["total_price"] . "</td>";
    $tabla .= "<td>" . ($fila["is_completed"] == 1 ? "Finalizado" : "En preparación") . "</td>";
    //Creamos un objeto de Fecha con el valor que viene de la base de datos
    $fecha_pedido = new DateTime($fila['client_order_date']);
    //Le damos el formato 'día/mes/Año' que quieres
    $tabla .= "<td>" . $fecha_pedido->format('d/m/Y') . "</td>";
    $tabla .= "</tr>";
}
$tabla .= "</tbody></table>";

// Cabecera HTML que incluye navbar
include_once("cabecera.html");
?>
<?php
echo $tabla;
?>
</body>

</html>