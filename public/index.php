<?php
session_start();
require_once __DIR__ . '/../config/constants.php';
require_once __DIR__ . '/../src/models/Alumno.php';
require_once __DIR__ . '/../src/models/Nota.php';

$titulo = 'Inicio';
require_once __DIR__ . '/../src/views/layouts/header.php';

// Obtener estadísticas
$alumnoModel = new Alumno();
$notaModel = new Nota();

$totalAlumnos = count($alumnoModel->getAll());
$alumnosConPromedio = $notaModel->getAllAlumnosConPromedio();

// Calcular estadísticas
$totalNotas = 0;
$sumaPromedios = 0;
$alumnosConNotas = 0;

foreach ($alumnosConPromedio as $alumno) {
    $totalNotas += $alumno['total_notas'];
    if ($alumno['promedio'] !== null) {
        $sumaPromedios += $alumno['promedio'];
        $alumnosConNotas++;
    }
}

$promedioGeneral = $alumnosConNotas > 0 ? round($sumaPromedios / $alumnosConNotas, 2) : 0;
?>

<!-- Hero Section -->
<div class="text-center mb-5">
    <h1 class="display-4 mb-3">
        <i class="bi bi-mortarboard-fill text-primary"></i>
        Sistema de Gestión de Alumnos y Notas
    </h1>
    <p class="lead text-muted">Administre alumnos, registre notas y genere reportes de manera eficiente</p>
</div>

<!-- Estadísticas -->
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card dashboard-card h-100">
            <div class="card-body text-center">
                <i class="bi bi-people-fill icon-large text-primary"></i>
                <h3 class="stat-number">
                    <?php echo $totalAlumnos; ?>
                </h3>
                <p class="text-muted mb-0">Alumnos Registrados</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card dashboard-card success h-100">
            <div class="card-body text-center">
                <i class="bi bi-journal-text icon-large text-success"></i>
                <h3 class="stat-number">
                    <?php echo $totalNotas; ?>
                </h3>
                <p class="text-muted mb-0">Notas Registradas</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card dashboard-card info h-100">
            <div class="card-body text-center">
                <i class="bi bi-graph-up icon-large text-info"></i>
                <h3 class="stat-number">
                    <?php echo $promedioGeneral; ?>
                </h3>
                <p class="text-muted mb-0">Promedio General</p>
            </div>
        </div>
    </div>
</div>

<!-- Acciones Rápidas -->
<h3 class="mb-4"><i class="bi bi-lightning-fill"></i> Acciones Rápidas</h3>
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="bi bi-person-plus-fill text-primary" style="font-size: 3rem;"></i>
                <h5 class="card-title mt-3">Nuevo Alumno</h5>
                <p class="card-text text-muted">Registre un nuevo alumno en el sistema</p>
                <a href="alumnos.php?action=crear" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Crear
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="bi bi-people-fill text-info" style="font-size: 3rem;"></i>
                <h5 class="card-title mt-3">Ver Alumnos</h5>
                <p class="card-text text-muted">Consulte el listado completo de alumnos</p>
                <a href="alumnos.php" class="btn btn-info">
                    <i class="bi bi-list-ul"></i> Ver Lista
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="bi bi-file-earmark-plus text-success" style="font-size: 3rem;"></i>
                <h5 class="card-title mt-3">Nueva Nota</h5>
                <p class="card-text text-muted">Registre una nueva nota para un alumno</p>
                <a href="notas.php?action=crear" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Registrar
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100 text-center">
            <div class="card-body">
                <i class="bi bi-file-earmark-bar-graph text-warning" style="font-size: 3rem;"></i>
                <h5 class="card-title mt-3">Reportes</h5>
                <p class="card-text text-muted">Genere reportes en Excel o PDF</p>
                <a href="reportes.php" class="btn btn-warning">
                    <i class="bi bi-download"></i> Generar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Últimos Alumnos -->
<?php if ($totalAlumnos > 0): ?>
    <h3 class="mb-4"><i class="bi bi-clock-history"></i> Últimos Alumnos Registrados</h3>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Correo</th>
                            <th class="text-center">Notas</th>
                            <th class="text-center">Promedio</th>
                            <th class="text-center">Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ultimosAlumnos = array_slice($alumnosConPromedio, 0, 5);
                        foreach ($ultimosAlumnos as $alumno):
                            ?>
                            <tr>
                                <td><strong>
                                        <?php echo htmlspecialchars($alumno['nombre'] . ' ' . $alumno['apellido']); ?>
                                    </strong></td>
                                <td>
                                    <?php echo htmlspecialchars($alumno['correo']); ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">
                                        <?php echo $alumno['total_notas']; ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($alumno['promedio'] !== null): ?>
                                        <strong class="text-primary">
                                            <?php echo number_format($alumno['promedio'], 2); ?>
                                        </strong>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <span class="badge <?php echo $alumno['badge_class']; ?>">
                                        <?php echo htmlspecialchars($alumno['resultado']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle-fill"></i>
        No hay alumnos registrados. Comience agregando un nuevo alumno usando el botón "Nuevo Alumno".
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/../src/views/layouts/footer.php'; ?>