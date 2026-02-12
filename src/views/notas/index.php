<?php
$titulo = 'Gestión de Notas';
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
    <h2><i class="bi bi-journal-text"></i> Gestión de Notas</h2>
    <a href="notas.php?action=crear" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Nueva Nota
    </a>
</div>

<!-- Tabla de notas -->
<?php if (empty($alumnos)): ?>
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <h4>No hay alumnos registrados</h4>
        <p>Debe registrar alumnos antes de poder asignar notas</p>
        <a href="alumnos.php?action=crear" class="btn btn-primary mt-3">
            <i class="bi bi-person-plus"></i> Registrar Alumno
        </a>
    </div>
<?php else: ?>
    <?php
    // Obtener todas las notas agrupadas por alumno
    require_once __DIR__ . '/../../models/Nota.php';
    $notaModel = new Nota();
    ?>

    <?php foreach ($alumnos as $alumno): ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="mb-0">
                            <i class="bi bi-person-fill"></i>
                            <?php echo htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']); ?>
                        </h5>
                        <small><?php echo htmlspecialchars($alumno['correo']); ?></small>
                    </div>
                    <div class="col-md-6 text-end">
                        <?php if ($alumno['promedio'] !== null): ?>
                            <h4 class="mb-0">
                                Promedio: <strong><?php echo number_format($alumno['promedio'], 2); ?></strong>
                                <span class="badge <?php echo $alumno['badge_class']; ?> ms-2">
                                    <?php echo htmlspecialchars($alumno['resultado']); ?>
                                </span>
                            </h4>
                        <?php else: ?>
                            <span class="badge bg-secondary">Sin notas</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?php
                // Obtener notas individuales del alumno
                $stmt = $notaModel->db->prepare("SELECT * FROM nota WHERE alumno_id = ? ORDER BY id DESC");
                $stmt->execute([$alumno['id']]);
                $notas = $stmt->fetchAll();
                ?>

                <?php if (empty($notas)): ?>
                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle"></i> Este alumno no tiene notas registradas.
                        <a href="notas.php?action=crear&alumno_id=<?php echo $alumno['id']; ?>" class="alert-link">
                            Agregar primera nota
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="10%">ID</th>
                                    <th width="60%">Nota</th>
                                    <th width="30%" class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($notas as $nota): ?>
                                    <tr>
                                        <td><?php echo $nota['id']; ?></td>
                                        <td>
                                            <span class="badge bg-primary" style="font-size: 1.1em;">
                                                <?php echo number_format($nota['valor'], 2); ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="notas.php?action=editar&id=<?php echo $nota['id']; ?>"
                                                class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a href="notas.php?action=eliminar&id=<?php echo $nota['id']; ?>"
                                                class="btn btn-sm btn-danger delete-link" title="Eliminar">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2 text-end">
                        <a href="notas.php?action=crear&alumno_id=<?php echo $alumno['id']; ?>" class="btn btn-sm btn-success">
                            <i class="bi bi-plus-circle"></i> Agregar otra nota
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Leyenda -->
    <div class="mt-3">
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill"></i> <strong>Escala de Calificación:</strong>
            <span class="badge bg-danger ms-2">0 - 4.99 = Suspenso</span>
            <span class="badge bg-info ms-2">5 - 6.99 = Bien</span>
            <span class="badge bg-primary ms-2">7 - 8.99 = Notable</span>
            <span class="badge bg-success ms-2">9 - 10 = Sobresaliente</span>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>