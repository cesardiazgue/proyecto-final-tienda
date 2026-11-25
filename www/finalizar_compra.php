<?php
session_start();
include "conexion.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];

// 1. Traer los productos del carrito con sus existencias y precios
$sql = "SELECT carrito.id_producto, carrito.cantidad, productos.precio, productos.cantidad_almacen
        FROM carrito
        INNER JOIN productos ON carrito.id_producto = productos.id_producto
        WHERE carrito.id_usuario = $id_usuario";
$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) == 0) {
    header("Location: carrito.php");
    exit();
}

// 2. Revisar que haya piezas suficientes de TODOS los productos
$productos = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    if ($fila["cantidad"] > $fila["cantidad_almacen"]) {
        header("Location: carrito.php?msg=sin_existencia");
        exit();
    }
    $productos[] = $fila;
}

// 3. Por cada producto: guardar en el historial y descontar del inventario
foreach ($productos as $p) {
    $id_producto = $p["id_producto"];
    $cantidad = $p["cantidad"];
    $precio = $p["precio"];

    $sql = "INSERT INTO historial_compras (id_usuario, id_producto, cantidad, precio)
            VALUES ($id_usuario, $id_producto, $cantidad, $precio)";
    mysqli_query($conexion, $sql);

    $sql = "UPDATE productos SET cantidad_almacen = cantidad_almacen - $cantidad
            WHERE id_producto = $id_producto";
    mysqli_query($conexion, $sql);
}

// 4. Vaciar el carrito del usuario
$sql = "DELETE FROM carrito WHERE id_usuario = $id_usuario";
mysqli_query($conexion, $sql);

mysqli_close($conexion);
header("Location: carrito.php?msg=compra");
exit();
?>