<?php
session_start();
include "conexion.php";
$pagina = "admin";

// Solo administradores
if (!isset($_SESSION["id_usuario"]) || $_SESSION["rol"] != "admin") {
    header("Location: index.php");
    exit();
}

$error = "";

// ---------- 1. Guardar (cuando se envía el formulario) ----------
if (isset($_POST["guardar"])) {

    $id = (int) $_POST["id_producto"];   // 0 = producto nuevo
    $nombre = mysqli_real_escape_string($conexion, $_POST["nombre"]);
    $descripcion = mysqli_real_escape_string($conexion, $_POST["descripcion"]);
    $precio = (float) $_POST["precio"];
    $cantidad = (int) $_POST["cantidad_almacen"];
    $fabricante = mysqli_real_escape_string($conexion, $_POST["fabricante"]);
    $origen = mysqli_real_escape_string($conexion, $_POST["origen"]);

    // Foto: solo si se eligió un archivo
    $foto = "";
    if ($_FILES["foto"]["name"] != "") {
        if (getimagesize($_FILES["foto"]["tmp_name"]) == false) {
            $error = "El archivo de la foto no es una imagen.";
        } else {
            // Nombre único: número de segundos + nombre original sin espacios
            $foto = time() . "_" . str_replace(" ", "_", basename($_FILES["foto"]["name"]));
            move_uploaded_file($_FILES["foto"]["tmp_name"], "img/" . $foto);
        }
    } else if ($id == 0) {
        $error = "Elige una foto para el producto nuevo.";
    }

    if ($error == "") {
        if ($id == 0) {
            // Producto nuevo
            $sql = "INSERT INTO productos (nombre, descripcion, foto, precio, cantidad_almacen, fabricante, origen)
                    VALUES ('$nombre', '$descripcion', '$foto', $precio, $cantidad, '$fabricante', '$origen')";
            $msg = "agregado";
        } else {
            // Producto existente: la foto solo cambia si se subió una nueva
            $sql = "UPDATE productos SET nombre = '$nombre', descripcion = '$descripcion', precio = $precio,
                    cantidad_almacen = $cantidad, fabricante = '$fabricante', origen = '$origen'";
            if ($foto != "") {
                $sql = $sql . ", foto = '$foto'";
            }
            $sql = $sql . " WHERE id_producto = $id";
            $msg = "modificado";
        }

        mysqli_query($conexion, $sql);
        mysqli_close($conexion);
        header("Location: admin.php?msg=$msg");
        exit();
    }
}

// ---------- 2. Cargar datos para mostrar el formulario ----------
// Valores vacíos para un producto nuevo
$producto = [
    "id_producto" => 0,
    "nombre" => "",
    "descripcion" => "",
    "foto" => "",
    "precio" => "",
    "cantidad_almacen" => "",
    "fabricante" => "",
    "origen" => ""
];

// Si viene un id en la URL, es para editar: se cargan sus datos
if (isset($_GET["id"])) {
    $id = (int) $_GET["id"];
    $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE id_producto = $id");
    if (mysqli_num_rows($resultado) == 1) {
        $producto = mysqli_fetch_assoc($resultado);
    }
}

$editando = ($producto["id_producto"] != 0);
if ($editando) {
    $titulo = "Editar producto";
} else {
    $titulo = "Agregar producto";
}

include "encabezado.php";
?>

<section class="py-5">
    <div class="container px-4 px-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <a href="admin.php" class="btn btn-link text-dark px-0 mb-3"><i class="bi-arrow-left me-1"></i>Volver al panel</a>
                <h1 class="fw-bolder mb-4"><?php echo $titulo; ?></h1>

                <?php if ($error != "") { ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php } ?>

                <div class="card">
                    <div class="card-body p-4">
                        <form method="post" action="producto_form.php" enctype="multipart/form-data">
                            <input type="hidden" name="id_producto" value="<?php echo $producto["id_producto"]; ?>">

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required
                                       value="<?php echo htmlspecialchars($producto["nombre"]); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($producto["descripcion"]); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="number" class="form-control" id="precio" name="precio" step="0.01" min="0" required
                                           value="<?php echo $producto["precio"]; ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cantidad_almacen" class="form-label">Cantidad en almacén</label>
                                    <input type="number" class="form-control" id="cantidad_almacen" name="cantidad_almacen" min="0" required
                                           value="<?php echo $producto["cantidad_almacen"]; ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fabricante" class="form-label">Fabricante</label>
                                    <input type="text" class="form-control" id="fabricante" name="fabricante" required
                                           value="<?php echo htmlspecialchars($producto["fabricante"]); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="origen" class="form-label">País de origen</label>
                                    <input type="text" class="form-control" id="origen" name="origen" required
                                           value="<?php echo htmlspecialchars($producto["origen"]); ?>">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="foto" class="form-label">Foto</label>
                                <?php if ($editando) { ?>
                                    <div class="mb-2">
                                        <img src="img/<?php echo $producto["foto"]; ?>" width="100" height="100"
                                             style="object-fit: contain;" class="border rounded p-1" alt="Foto actual">
                                    </div>
                                <?php } ?>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                <?php if ($editando) { ?>
                                    <div class="form-text">Déjalo vacío para conservar la foto actual.</div>
                                <?php } ?>
                            </div>

                            <button type="submit" name="guardar" class="btn btn-dark w-100">Guardar producto</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php
mysqli_close($conexion);
include "pie.php";
?>