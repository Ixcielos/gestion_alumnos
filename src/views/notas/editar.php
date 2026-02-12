<?php
$titulo = 'Editar Nota';
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/notas.php">Notas</a></li>
        <li class="breadcrumb-item active">Editar Nota</li>
    </ol>
</nav>

<h2 class="mb-4"><i class="bi bi-pencil-square"></i> Editar Nota</h2>

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
        <i class="bi bi-file-earmark-text"></i> Datos de la Nota
    </div>
    <div class="card-body">
        <form method="POST" action="notas.php?action=editar&id=<?php echo $nota['id']; ?>">
            <div class="mb-3">
                <label class="form-label">Alumno</label>
                <input type="text" class="form-control"
                    value="<?php echo htmlspecialchars($nota['nombre'] . ' ' . $nota['apellido']); ?>" disabled>
                <div class="form-text">El alumno no puede ser modificado</div>
            </div>

            <div class="mb-3">
                <label for="valor" class="form-label">Nota <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="valor" name="valor" step="0.01" min="0" max="10"
                    value="<?php echo isset($_POST['valor']) ? htmlspecialchars($_POST['valor']) : htmlspecialchars($nota['valor']); ?>"
                    required>
                <div class="form-text">Ingrese una nota entre 0 y 10</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Actualizar
                </button>
                <a href="notas.php" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>