<?php
session_start();
include "conexion.php";
$titulo = "Mi perfil";
$pagina = "perfil";

// Solo usuarios con sesión iniciada pueden ver esta página
if (!isset($_SESSION["id_usuario"])) {
    header("Location: login.php");
    exit();
}

// Traer los datos del usuario que inició sesión
$id = $_SESSION["id_usuario"];
$sql = "SELECT * FROM usuarios WHERE id_usuario = $id";
$resultado = mysqli_query($conexion, $sql);
$usuario = mysqli_fetch_assoc($resultado);

// Mostrar solo los últimos 4 dígitos de la tarjeta
$ultimos4 = substr($usuario["tarjeta"], -4);

include "encabezado.php";
?>

<section class="py-5">
    <div class="container px-4 px-lg-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <h1 class="fw-bolder mb-4">Mi perfil</h1>

                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <i class="bi-person-circle me-2"></i>Datos de la cuenta
                    </div>
                    <div class="card-body p-4">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Nombre</dt>
                            <dd class="col-sm-8"><?php echo htmlspecialchars($usuario["nombre"]); ?></dd>

                            <dt class="col-sm-4">Correo electrónico</dt>
                            <dd class="col-sm-8"><?php echo htmlspecialchars($usuario["correo"]); ?></dd>

                            <dt class="col-sm-4">Fecha de nacimiento</dt>
                            <dd class="col-sm-8"><?php echo date("d/m/Y", strtotime($usuario["fecha_nacimiento"])); ?></dd>

                            <dt class="col-sm-4">Tarjeta bancaria</dt>
                            <dd class="col-sm-8">**** **** **** <?php echo htmlspecialchars($ultimos4); ?></dd>

                            <dt class="col-sm-4">Dirección postal</dt>
                            <dd class="col-sm-8"><?php echo htmlspecialchars($usuario["direccion"]); ?></dd>

                            <dt class="col-sm-4">Tipo de cuenta</dt>
                            <dd class="col-sm-8 mb-0"><span class="badge bg-secondary"><?php echo $usuario["rol"]; ?></span></dd>
                        </dl>
                    </div>
                </div>

                <a href="logout.php" class="btn btn-outline-dark mt-4">Cerrar sesión</a>

            </div>
        </div>
    </div>
</section>

<?php
mysqli_close($conexion);
include "pie.php";
?>