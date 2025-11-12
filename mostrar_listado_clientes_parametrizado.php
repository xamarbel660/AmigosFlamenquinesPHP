<?php
include_once("config.php");

$conexion = obtenerConexion();



// Cabecera HTML que incluye navbar
include_once("form_listado_parametrizado_clientes.php");

$sql = "SELECT * FROM client";
$nombreCliente = trim($_GET["nombreCliente"] ?? "");
$edadCliente = trim($_GET["edadCliente"] ?? "");
$fechaAnyadido = trim($_GET["fechaAnyadido"] ?? "");
$esVip = trim($_GET["lstEsVip"] ?? "-1");

$condiciones = [];

if ($nombreCliente !== "") {
    $condiciones[] = "name LIKE '%$nombreCliente%'";
}
if ($edadCliente !== "") {
    $condiciones[] = "age = " . intval($edadCliente);
}
if ($fechaAnyadido !== "") {
    $condiciones[] = "date_created_account = '$fechaAnyadido'";
}
if ($esVip !== "-1") {
    $condiciones[] = "is_vip = " . intval($esVip);
}

if (!empty($condiciones)) {
    $sql .= " WHERE " . implode(" AND ", $condiciones);
}

$sql .= ";";






$tabla = "<table class='table table-striped text-center mt-3' id='listadoClientes'>";
$tabla .= "<thead><tr><th>ID-CLIENTE</th><th>NOMBRE</th><th>EDAD</th><th>ES VIP</th><th>FECHA AÑADIDO</th>";
$idCliente = "";

    
$resultado = mysqli_query($conexion, $sql);

$tabla.= "</tr></thead><tbody>";
while ($fila = mysqli_fetch_assoc($resultado)) {
    // Insertar una fila al final
    if ($fila["is_vip"] == "1") {
        $esVip = "Si";
    }else{
        $esVip = "No";
    }
    $tabla .= "<tr>";
    $tabla .= "<td>". $fila["id_client"] ."</td>";
    $tabla .= "<td>". $fila["name"] ."</td>";
    $tabla .= "<td>". $fila["age"] ."</td>";
    $tabla .= "<td>". $esVip ."</td>";
    $fecha = implode('-',array_reverse(explode('-',$fila['date_created_account'])));
    $tabla .= "<td>". $fecha ."</td>";
    $tabla .= "</tr>";
    
}
$tabla .= "</tbody></table>";

?>
    <?php 
        echo $tabla; 
    ?>
</body>

</html>