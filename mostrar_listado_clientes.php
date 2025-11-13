<?php
include_once("config.php");

$conexion = obtenerConexion();

// Cabecera HTML que incluye navbar
include_once("cabecera.html");

$tabla = "<table class='table table-striped text-center' id='listadoClientes'>";
$tabla .= "<thead><tr><th>ID-CLIENTE</th><th>NOMBRE</th><th>EDAD</th><th>CATEGORIA</th><th>ES VIP</th><th>FECHA AÑADIDO</th>";
$idCliente = "";
$sql = "SELECT * FROM client INNER JOIN category ON client.id_category = category.id_category ORDER BY date_created_account";
    
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
    $tabla .= "<td>". $fila["category_name"] ."</td>";
    $tabla .= "<td>". $esVip ."</td>";
    $fecha = implode('-',array_reverse(explode('-',$fila['date_created_account'])));
    $tabla .= "<td>". $fecha ."</td>";
    $tabla .= "</tr>";
    
}
$tabla .= "</tbody></table>";

?>
    <h2 class="text-center" style="
        font-family: 'Open Sans', sans-serif;">Listado clientes almacenados</h2>
    <?php 
        echo $tabla; 
    ?>
</body>

</html>