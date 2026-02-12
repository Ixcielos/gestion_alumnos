<?php
$titulo = 'Nueva Nota';
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo BASE_URL; ?>/notas.php">Notas</a></li>
        <li class="breadcrumb-item active">Nueva Nota</li>
    </ol>
</nav>

<h2 class="mb-4"><i class="bi bi-file-earmark-plus"></i> Registrar Nueva Nota</h2>

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
        <?php if (empty($alumnos)): ?>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle-fill"></i> No hay alumnos registrados.
                <a href="alumnos.php?action=crear" class="alert-link">Registre un alumno primero</a>.
            </div>
        <?php else: ?>
            <form method="POST" action="notas.php?action=crear">
                <div class="mb-3">
                    <label for="alumno_id" class="form-label">Alumno <span class="text-danger">*</span></label>
                    <select class="form-select" id="alumno_id" name="alumno_id" required>
                        <option value="">Seleccione un alumno...</option>
                        <?php foreach ($alumnos as $alumno): ?>
                            <option value="<?php echo $alumno['id']; ?>" <?php echo (isset($_POST['alumno_id']) && $_POST['alumno_id'] == $alumno['id']) ||
                                   (isset($_GET['alumno_id']) && $_GET['alumno_id'] == $alumno['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="valor" class="form-label">Nota <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="valor" name="valor" step="0.01" min="0" max="10"
                        value="<?php echo isset($_POST['valor']) ? htmlspecialchars($_POST['valor']) : ''; ?>" required>
                    <div class="form-text">Ingrese una nota entre 0 y 10</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Guardar
                    </button>
                    <a href="notas.php" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<!-- Información adicional -->
<div class="mt-4">
    <div class="alert alert-info">
        <i class="bi bi-info-circle-fill"></i> <strong>Escala de Calificación:</strong><br>
        <ul class="mb-0 mt-2">
            <li>0 - 4.99: Suspenso</li>
            <li>5 - 6.99: Bien</li>
            <li>7 - 8.99: Notable</li>
            <li>9 - 10: Sobresaliente</li>
        </ul>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>