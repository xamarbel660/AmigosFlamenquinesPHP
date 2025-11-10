<?php
require_once("config.php");
$conexion = obtenerConexion();

// Recuperar parámetros
$idpedido = $_POST['id_client_order'];

// No validamos, suponemos que la entrada de datos es correcta

// Definir delete
// DELETE FROM `client_order` WHERE `client_order`.`id_client_order` = 21;
$sql = "DELETE FROM client_order WHERE id_client_order = $idpedido;";

// Ejecutar consulta
$resultado = mysqli_query($conexion, $sql);

// Verificar si hay error y almacenar mensaje
if (mysqli_errno($conexion) != 0) {
    $numerror = mysqli_errno($conexion);
    $descrerror = mysqli_error($conexion);
    $mensaje =  "<h2 class='text-center mt-5'>Se ha producido un error numero $numerror que corresponde a: $descrerror </h2>";
} else {
    $mensaje =  "<h2 class='text-center mt-5'>Componente con id $idcomponente borrado</h2>"; 
}

header("refresh:5;url=index.php");
include_once("cabecera.html");

// Mostrar mensaje calculado antes
echo $mensaje;

?>
</body>
</html>