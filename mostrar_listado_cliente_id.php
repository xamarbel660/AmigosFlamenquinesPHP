<?php
include_once("config.php");

$conexion = obtenerConexion();



// Cabecera HTML que incluye navbar
include_once("cabecera.html");

$tabla = "<table class='table table-striped' id='listadoClientes'>";
$tabla .= "<thead><tr><th>ID-CLIENTE</th><th>NOMBRE</th><th>EDAD</th><th>ES VIP</th><th>FECHA AÑADIDO</th>";
$tabla .= "<th>ACCIÓN</th>";
$tabla.= "</tr></thead><tbody>";

$idCliente = "";
$vaBuscarId = isset($_GET["idClienteBuscar"]);
if ($vaBuscarId && $_GET["idClienteBuscar"] != "") {
    $idCliente = $_GET["idClienteBuscar"];
    $sql = "SELECT * FROM client WHERE id_client = $idCliente ;";
    
}else{
    $sql = "SELECT * FROM client ORDER BY date_created_account";
    
}

$resultado = mysqli_query($conexion, $sql);


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
    $tabla .= "<td>". $fila["date_created_account"] ."</td>";
    $tabla .= "<td><form class='d-inline me-1' action='form_editar_cliente.php' method='get'>";
    $tabla .= "<input type='hidden' name='cliente' value='" . htmlspecialchars(json_encode($fila),ENT_QUOTES) . "' />";
    $tabla .= "<button name='Editar' class='btn bg-secondary'><i class='bi bi-pencil-square'></i></button></form>";

            $tabla .= "</td></tr>";
       
    
}
$tabla .= "</tbody></table>";

?>
    <h2 class="text-center" style="
        font-family: 'Open Sans', sans-serif;">Listado Cliente</h2>
    <?php 
        echo $tabla; 
    ?>
</body>

</html>