<?php
$titulo = 'Listado de Alumnos';
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- Mensajes -->
<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?> alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i>
        <?php echo $_SESSION['mensaje']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
<?php endif; ?>

<!-- Header de la página -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people-fill"></i> Listado de Alumnos</h2>
    <a href="alumnos.php?action=crear" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Alumno
    </a>
</div>

<!-- Tabla de alumnos -->
<?php if (empty($alumnos)): ?>
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <h4>No hay alumnos registrados</h4>
        <p>Comience agregando un nuevo alumno usando el botón "Nuevo Alumno"</p>
    </div>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo Electrónico</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alumnos as $alumno): ?>
                            <tr>
                                <td>
                                    <?php echo htmlspecialchars($alumno['id']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($alumno['nombre']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($alumno['apellido']); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($alumno['correo']); ?>
                                </td>
                                <td class="text-center">
                                    <a href="alumnos.php?action=editar&id=<?php echo $alumno['id']; ?>"
                                        class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="alumnos.php?action=eliminar&id=<?php echo $alumno['id']; ?>"
                                        class="btn btn-sm btn-danger delete-link" title="Eliminar">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3 text-muted">
        <i class="bi bi-info-circle"></i> Total de alumnos: <strong>
            <?php echo count($alumnos); ?>
        </strong>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>