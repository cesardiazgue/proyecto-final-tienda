<?php
session_start();
include "conexion.php";
$titulo = "Crear cuenta";
$pagina = "registro";

$mensaje = "";
$tipo = "";

// Solo se procesa si el usuario dio clic en "Crear cuenta"
if (isset($_POST["registrar"])) {

    // 1. Recibir y limpiar los datos del formulario
    $nombre = mysqli_real_escape_string($conexion, $_POST["nombre"]);
    $correo = mysqli_real_escape_string($conexion, $_POST["correo"]);
    $contrasena = $_POST["contrasena"];
    $fecha_nacimiento = mysqli_real_escape_string($conexion, $_POST["fecha_nacimiento"]);
    $tarjeta = mysqli_real_escape_string($conexion, $_POST["tarjeta"]);
    $direccion = mysqli_real_escape_string($conexion, $_POST["direccion"]);

    // 2. Revisar que el correo no esté registrado
    $sql = "SELECT id_usuario FROM usuarios WHERE correo = '$correo'";
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $mensaje = "Ya existe una cuenta con ese correo.";
        $tipo = "danger";
    } else {
        // 3. Encriptar la contraseña
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);

        // 4. Guardar el usuario
        $sql = "INSERT INTO usuarios (nombre, correo, contrasena, fecha_nacimiento, tarjeta, direccion)
                VALUES ('$nombre', '$correo', '$hash', '$fecha_nacimiento', '$tarjeta', '$direccion')";

        if (mysqli_query($conexion, $sql)) {
            $mensaje = "¡Cuenta creada! Ya puedes <a href='login.php' class='alert-link'>iniciar sesión</a>.";
            $tipo = "success";
        } else {
            $mensaje = "Error al crear la cuenta: " . mysqli_error($conexion);
            $tipo = "danger";
        }
    }
}

include "encabezado.php";
?>

<section class="py-5">
    <div class="container px-4 px-lg-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <h1 class="fw-bolder mb-4">Crear cuenta</h1>

                <?php if ($mensaje != "") { ?>
                    <div class="alert alert-<?php echo $tipo; ?>"><?php echo $mensaje; ?></div>
                <?php } ?>

                <div class="card">
                    <div class="card-body p-4">
                        <form method="post" action="registro.php">

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>

                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>

                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" minlength="6" required>
                                <div class="form-text">Mínimo 6 caracteres.</div>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                            </div>

                            <div class="mb-3">
                                <label for="tarjeta" class="form-label">Número de tarjeta bancaria</label>
                                <input type="text" class="form-control" id="tarjeta" name="tarjeta"
                                       maxlength="19" pattern="[0-9 ]{13,19}" placeholder="4111 1111 1111 1111" required>
                                <div class="form-text">Usa un número de prueba, nunca uno real.</div>
                            </div>

                            <div class="mb-4">
                                <label for="direccion" class="form-label">Dirección postal</label>
                                <textarea class="form-control" id="direccion" name="direccion" rows="2" required></textarea>
                            </div>

                            <button type="submit" name="registrar" class="btn btn-dark w-100">Crear cuenta</button>
                        </form>
                    </div>
                </div>

                <p class="text-center mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>

            </div>
        </div>
    </div>
</section>

<?php
mysqli_close($conexion);
include "pie.php";
?>