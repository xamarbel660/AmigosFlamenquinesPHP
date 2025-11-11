<?php
require_once("config.php");
$conexion = obtenerConexion();

// Recuperar parámetros
$idcliente = $_POST['lstCliente'];
$comentario = $_POST['txtComentario'];
$estadofinalizado = $_POST['estado'];
$idpedido = $_POST['idPedido'];

$platosDataJSON = $_POST['platos_con_cantidad'];
$platosData = json_decode($platosDataJSON, true);

$total_price = 0;

foreach ($platosData as $plato) {
    $idPlato = $plato['idPlato'];
    $cantidad = $plato['cantidad'];
    
    // ¡Consulta insegura! Pero es el estilo que pides.
    $sqlPrecio = "SELECT price FROM plate WHERE id_plate = $idPlato";
    $resPrecio = mysqli_query($conexion, $sqlPrecio);
    
    if ($filaPrecio = mysqli_fetch_assoc($resPrecio)) {
        $total_price += ($filaPrecio['price'] * $cantidad);
    }
}

// No validamos, suponemos que la entrada de datos es correcta

// Definir update
$sql = "UPDATE componente SET nombre = '" . $nombre . "' , descripcion = '" . $descripcion . "' , precio = $precio , idtipo = $idtipo WHERE idcomponente = $idcomponente ;";

// Ejecutar consulta
// $resultado = mysqli_query($conexion, $sql);

// Verificar si hay error y almacenar mensaje
// if (mysqli_errno($conexion) != 0) {
//     $numerror = mysqli_errno($conexion);
//     $descrerror = mysqli_error($conexion);
//     $mensaje =  "<h2 class='text-center mt-5'>Se ha producido un error numero $numerror que corresponde a: $descrerror </h2>";
// } else {
//     $mensaje =  "<h2 class='text-center mt-5'>Componente actualizado</h2>";
// }

// Aquí empieza la página
include_once("cabecera.html");

// Mostrar mensaje calculado antes
// echo $mensaje;

?>

