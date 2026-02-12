<?php
$titulo = 'Nuevo Alumno';
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/alumnos.php">Alumnos</a></li>
        <li class="breadcrumb-item active">Nuevo Alumno</li>
    </ol>
</nav>

<h2 class="mb-4"><i class="bi bi-person-plus-fill"></i> Registrar Nuevo Alumno</h2>

<!-- Mensajes de error -->
<?php if ($this->getMensaje()): ?>
    <div class="alert alert-<?php echo $this->getTipoMensaje(); ?> alert-dismissible fade show" role="alert">
        <?php echo $this->getMensaje(); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Formulario -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-file-earmark-text"></i> Datos del Alumno
    </div>
    <div class="card-body">
        <form method="POST" action="alumnos.php?action=crear">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50"
                        value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>"
                        required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="apellido" name="apellido" maxlength="50"
                        value="<?php echo isset($_POST['apellido']) ? htmlspecialchars($_POST['apellido']) : ''; ?>"
                        required>
                </div>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="correo" name="correo" maxlength="100"
                    value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>" required>
                <div class="form-text">Ingrese un correo electrónico válido</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Guardar
                </button>
                <a href="alumnos.php" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>