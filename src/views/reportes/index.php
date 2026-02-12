<?php
$titulo = 'Reportes';
require_once __DIR__ . '/../layouts/header.php';
?>

<!-- Mensajes -->
<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['mensaje']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
<?php endif; ?>

<h2 class="mb-4"><i class="bi bi-file-earmark-bar-graph"></i> Generación de Reportes</h2>

<div class="row g-4">
    <!-- Reporte Excel -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-file-earmark-excel-fill text-success" style="font-size: 5rem;"></i>
                <h4 class="card-title mt-3">Reporte Excel</h4>
                <p class="card-text text-muted">
                    Genere un reporte completo de alumnos y notas en formato Excel (.xlsx)
                    con formato profesional y colores según el rendimiento.
                </p>
                <ul class="list-unstyled text-start mb-4">
                    <li><i class="bi bi-check-circle-fill text-success"></i> Formato profesional</li>
                    <li><i class="bi bi-check-circle-fill text-success"></i> Colores por rendimiento</li>
                    <li><i class="bi bi-check-circle-fill text-success"></i> Fácil de editar</li>
                    <li><i class="bi bi-check-circle-fill text-success"></i> Compatible con Excel/LibreOffice</li>
                </ul>
                <a href="reportes.php?action=excel" class="btn btn-success btn-lg">
                    <i class="bi bi-download"></i> Descargar Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Reporte PDF -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-file-earmark-pdf-fill text-danger" style="font-size: 5rem;"></i>
                <h4 class="card-title mt-3">Reporte PDF</h4>
                <p class="card-text text-muted">
                    Genere un reporte completo de alumnos y notas en formato PDF
                    listo para imprimir o compartir.
                </p>
                <ul class="list-unstyled text-start mb-4">
                    <li><i class="bi bi-check-circle-fill text-danger"></i> Formato profesional</li>
                    <li><i class="bi bi-check-circle-fill text-danger"></i> Listo para imprimir</li>
                    <li><i class="bi bi-check-circle-fill text-danger"></i> Universal (PDF)</li>
                    <li><i class="bi bi-check-circle-fill text-danger"></i> Incluye leyenda de calificación</li>
                </ul>
                <a href="reportes.php?action=pdf" class="btn btn-danger btn-lg">
                    <i class="bi bi-download"></i> Descargar PDF
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Vista previa de datos -->
<?php if (!empty($alumnos)): ?>
    <div class="mt-5">
        <h4 class="mb-3"><i class="bi bi-eye"></i> Vista Previa de Datos</h4>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th class="text-center">Promedio</th>
                                <th class="text-center">Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alumnos as $alumno): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($alumno['id']); ?></td>
                                    <td><?php echo htmlspecialchars($alumno['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($alumno['apellido']); ?></td>
                                    <td><?php echo htmlspecialchars($alumno['correo']); ?></td>
                                    <td class="text-center">
                                        <?php if ($alumno['promedio'] !== null): ?>
                                            <strong><?php echo number_format($alumno['promedio'], 2); ?></strong>
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
                <div class="mt-3 text-muted">
                    <i class="bi bi-info-circle"></i> Total de registros a exportar:
                    <strong><?php echo count($alumnos); ?></strong>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning mt-4">
        <i class="bi bi-exclamation-triangle-fill"></i>
        No hay datos para generar reportes. Registre alumnos y notas primero.
    </div>
<?php endif; ?>

<!-- Información adicional -->
<div class="mt-4">
    <div class="alert alert-info">
        <h5><i class="bi bi-info-circle-fill"></i> Información sobre los Reportes</h5>
        <ul class="mb-0">
            <li><strong>Excel:</strong> Ideal para análisis de datos, permite edición y cálculos adicionales</li>
            <li><strong>PDF:</strong> Ideal para impresión y distribución, formato universal</li>
            <li>Ambos reportes incluyen todos los alumnos con sus promedios y resultados cualitativos</li>
            <li>Los reportes se generan en tiempo real con los datos actuales del sistema</li>
        </ul>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>