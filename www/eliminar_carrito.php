<?php
session_start();
include "conexion.php";

if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];
$id_carrito = (int) $_POST["id_carrito"];

// Solo se borra si esa fila del carrito es de este usuario
$sql = "DELETE FROM carrito WHERE id_carrito = $id_carrito AND id_usuario = $id_usuario";
mysqli_query($conexion, $sql);

mysqli_close($conexion);
header("Location: carrito.php?msg=eliminado");
exit();
?>