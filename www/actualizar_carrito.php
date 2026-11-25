<?php
session_start();
include "conexion.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];
$id_carrito = (int) $_POST["id_carrito"];
$cantidad = (int) $_POST["cantidad"];

if ($cantidad < 1) {
    $cantidad = 1;
}

// Revisar las piezas en almacén del producto de esa fila del carrito
$sql = "SELECT productos.cantidad_almacen
        FROM carrito
        INNER JOIN productos ON carrito.id_producto = productos.id_producto
        WHERE carrito.id_carrito = $id_carrito AND carrito.id_usuario = $id_usuario";
$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) == 1) {
    $fila = mysqli_fetch_assoc($resultado);

    if ($cantidad > $fila["cantidad_almacen"]) {
        $cantidad = $fila["cantidad_almacen"];
    }

    $sql = "UPDATE carrito SET cantidad = $cantidad
            WHERE id_carrito = $id_carrito AND id_usuario = $id_usuario";
    mysqli_query($conexion, $sql);
}

mysqli_close($conexion);
header("Location: carrito.php?msg=actualizado");
exit();
?>