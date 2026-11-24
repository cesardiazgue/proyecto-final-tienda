<?php
session_start();
include "conexion.php";
$titulo = "Iniciar sesión";
$pagina = "login";

$mensaje = "";

// Si ya inició sesión, no tiene caso mostrar el login
if (isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

// Solo se procesa si el usuario dio clic en "Entrar"
if (isset($_POST["entrar"])) {

    // 1. Recibir los datos
    $correo = mysqli_real_escape_string($conexion, $_POST["correo"]);
    $contrasena = $_POST["contrasena"];

    // 2. Buscar al usuario por su correo
    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) == 1) {
        $usuario = mysqli_fetch_assoc($resultado);

        // 3. Comparar la contraseña escrita contra el hash guardado
        if (password_verify($contrasena, $usuario["contrasena"])) {

            // 4. Guardar los datos del usuario en la sesión
            $_SESSION["id_usuario"] = $usuario["id_usuario"];
            $_SESSION["nombre"] = $usuario["nombre"];
            $_SESSION["rol"] = $usuario["rol"];

            // 5. Mandarlo a la página de inicio
            header("Location: index.php");
            exit();
        }
    }

    // Si llegó aquí, el correo o la contraseña no coinciden
    $mensaje = "Correo o contraseña incorrectos.";
}

include "encabezado.php";
?>

<section class="py-5">
    <div class="container px-4 px-lg-5">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">

                <h1 class="fw-bolder mb-4">Iniciar sesión</h1>

                <?php if ($mensaje != "") { ?>
                    <div class="alert alert-danger"><?php echo $mensaje; ?></div>
                <?php } ?>

                <div class="card">
                    <div class="card-body p-4">
                        <form method="post" action="login.php">

                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>

                            <div class="mb-4">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                            </div>

                            <button type="submit" name="entrar" class="btn btn-dark w-100">Entrar</button>
                        </form>
                    </div>
                </div>

                <p class="text-center mt-3">¿No tienes cuenta? <a href="registro.php">Crea una aquí</a></p>

            </div>
        </div>
    </div>
</section>

<?php
mysqli_close($conexion);
include "pie.php";
?>