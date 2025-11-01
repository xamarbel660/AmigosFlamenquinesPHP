<?php
require_once("config.php");
function obtenerPrecioTotal() {

}


$sql2 = "SELECT id_plate, name FROM plate;";

$resultado2 = mysqli_query($conexion, $sql2);

$platos = "";
while ($fila = mysqli_fetch_assoc($resultado2)) {
    $platos .= " <option value='" . $fila["id_plate"] . "'>" . $fila["name"] . "</option>";
}

// Ejecutar consulta
$resultado = mysqli_query($conexion, $sql);

// Verificar si hay error y almacenar mensaje
if (mysqli_errno($conexion) != 0) {
    $numerror = mysqli_errno($conexion);
    $descrerror = mysqli_error($conexion);
    $mensaje =  "<h2 class='text-center mt-5'>Se ha producido un error numero $numerror que corresponde a: $descrerror </h2>";
} else {
    $mensaje =  "<h2 class='text-center mt-5'>Reserva añadida</h2>"; 
}
// Redireccionar tras 5 segundos al index.
// Siempre debe ir antes de DOCTYPE
header( "refresh:5;url=index.php" );

// Aquí empieza la página
include_once("cabecera.html");

// Mostrar mensaje calculado antes
echo $mensaje;

?>
</body>
</html>