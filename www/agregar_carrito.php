<?php
session_start();
include "conexion.php";

// Solo usuarios con sesión pueden agregar al carrito
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];
$id_producto = (int) $_POST["id_producto"];
$cantidad = (int) $_POST["cantidad"];

if ($cantidad < 1) {
    $cantidad = 1;
}

// 1. Revisar cuántas piezas hay en almacén
$sql = "SELECT cantidad_almacen FROM productos WHERE id_producto = $id_producto";
$resultado = mysqli_query($conexion, $sql);
$producto = mysqli_fetch_assoc($resultado);

if ($producto == null || $producto["cantidad_almacen"] == 0) {
    header("Location: carrito.php?msg=agotado");
    exit();
}

$existencia = $producto["cantidad_almacen"];

// 2. ¿El producto ya está en el carrito de este usuario?
$sql = "SELECT id_carrito, cantidad FROM carrito
        WHERE id_usuario = $id_usuario AND id_producto = $id_producto";
$resultado = mysqli_query($conexion, $sql);

if (mysqli_num_rows($resultado) > 0) {
    // Ya está: se suma la cantidad
    $fila = mysqli_fetch_assoc($resultado);
    $id_carrito = $fila["id_carrito"];
    $nueva = $fila["cantidad"] + $cantidad;

    if ($nueva > $existencia) {
        $nueva = $existencia;
    }

    $sql = "UPDATE carrito SET cantidad = $nueva WHERE id_carrito = $id_carrito";
} else {
    // No está: se agrega una fila nueva
    if ($cantidad > $existencia) {
        $cantidad = $existencia;
    }

    $sql = "INSERT INTO carrito (id_usuario, id_producto, cantidad)
            VALUES ($id_usuario, $id_producto, $cantidad)";
}

mysqli_query($conexion, $sql);
mysqli_close($conexion);

header("Location: carrito.php?msg=agregado");
exit();
?>