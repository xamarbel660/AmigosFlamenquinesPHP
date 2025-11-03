<?php
require_once("config.php");
$conexion = obtenerConexion();

// Recuperar parámetros
$idCliente = intval($_POST['idCliente']);

// No validamos, suponemos que la entrada de datos es correcta

// Definir delete
$sql = "DELETE FROM client WHERE id_client = $idCliente;";

// Ejecutar consulta
$resultado = mysqli_query($conexion, $sql);

// Verificar si hay error y almacenar mensaje
if (mysqli_errno($conexion) != 0) {
    $numerror = mysqli_errno($conexion);
    $descrerror = mysqli_error($conexion);
    $mensaje =  "<h2 class='text-center mt-5'>Se ha producido un error numero $numerror que corresponde a: $descrerror </h2>";
} else {
    $mensaje =  "<h2 class='text-center mt-5'>Se ha eliminado el cliente con el ID:$idCliente </h2>"; 
}
header( header: "refresh:5;url=index.php" );
include_once("cabecera.html");

// Mostrar mensaje calculado antes
echo $mensaje;

?>