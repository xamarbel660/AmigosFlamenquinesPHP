<?php
require_once("config.php");
$conexion = obtenerConexion();

// Recuperar parámetros
$id_tipo = $_POST['numTipo'];
$nombre_tipo = $_POST['txtTipo'];
$descripcion = $_POST['txtDescripcion'];

// No validamos, suponemos que la entrada de datos es correcta

// Definir update
    $sql = 'UPDATE tipo SET tipo = "'.$nombre_tipo.'", descripcion = "'.$descripcion.'" WHERE tipo.idtipo ='.$id_tipo.';';

// Ejecutar consulta
$resultado = mysqli_query($conexion, $sql);

// Verificar si hay error y almacenar mensaje
if (mysqli_errno($conexion) != 0) {
    $numerror = mysqli_errno($conexion);
    $descrerror = mysqli_error($conexion);
    $mensaje =  "<h2 class='text-center mt-5'>Se ha producido un error numero $numerror que corresponde a: $descrerror </h2>";
} else {
    $mensaje =  "<h2 class='text-center mt-5'>Componente actualizado</h2>";
}

// Aquí empieza la página
include_once("cabecera.html");

// Mostrar mensaje calculado antes
echo $mensaje;

?>

