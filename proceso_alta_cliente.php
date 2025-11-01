<?php
require_once("config.php");
$conexion = obtenerConexion();

// Recuperar parámetros
$idcliente = $_POST['lstCliente'];
$fechaReserva = $_POST['fechaReserva'];
$comentario = $_POST['textAreaComentario'];
$total_price = $_POST['numPrecio'];


// No validamos, suponemos que la entrada de datos es correcta

// Definir insert
// El campo is_completed se pone a 0 por defecto, porque cuando se crea el pedido, no está completado
$sql = "INSERT INTO client_order(`client_order_date`, `total_price`, `is_completed`, `comment`, `id_client`) 
                VALUES ('" . $fechaReserva . "', '$total_price', '0', '" . $comentario . "', $idcliente );";

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