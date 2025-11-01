<?php
include_once("config.php");

$conexion = obtenerConexion();

$sql = "SELECT * FROM client";

$resultado = mysqli_query($conexion, $sql);

// Cabecera HTML que incluye navbar
include_once("cabecera.html");

$tabla = "<table class='table table-striped' id='listadoClientesAlmacenados'>";
$tabla .= "<thead><tr><th>ID-CLIENTE</th><th>NOMBRE</th><th>EDAD</th><th>ES VIP</th><th>FECHA AÑADIDO</th></tr></thead><tbody>";
while ($fila = mysqli_fetch_assoc($resultado)) {
    // Insertar una fila al final
    if ($fila["is_vip"] == "1") {
        $esVip = "No";
    }else{
        $esVip = "Si";
    }
    $tabla .= "<tr>";
    $tabla .= "<td>". $fila["id_client"] ."</td>";
    $tabla .= "<td>". $fila["name"] ."</td>";
    $tabla .= "<td>". $fila["age"] ."</td>";
    $tabla .= "<td>". $esVip ."</td>";
    $tabla .= "<td>". $fila["date_created_account"] ."</td>";    
    $tabla .= "</tr>";

    
}
$tabla .= "</tbody></table>";

?>
    <h2 class="text-center" style="
font-family: 'Open Sans', sans-serif;">Listado de clientes</h2>
    <?php 
        echo $tabla; 
    ?>
</body>

</html>