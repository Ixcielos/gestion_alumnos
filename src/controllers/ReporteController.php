<?php
require_once __DIR__ . '/../../config/constants.php';
require_once __DIR__ . '/../models/Nota.php';

// Verificar si Composer está instalado
if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    require_once __DIR__ . '/../../vendor/autoload.php';
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

/**
 * Controlador de Reportes
 */
class ReporteController
{
    private $notaModel;

    public function __construct()
    {
        $this->notaModel = new Nota();
    }

    /**
     * Mostrar página de reportes
     */
    public function index()
    {
        $alumnos = $this->notaModel->getAllAlumnosConPromedio();
        require_once __DIR__ . '/../views/reportes/index.php';
    }

    /**
     * Generar reporte en Excel
     */
    public function generarExcel()
    {
        // Verificar que PhpSpreadsheet esté instalado
        if (!class_exists('PhpOffice\PhpSpreadsheet\Spreadsheet')) {
            $_SESSION['mensaje'] = 'PhpSpreadsheet no está instalado. Ejecute: composer install';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: reportes.php');
            exit;
        }

        try {
            $alumnos = $this->notaModel->getAllAlumnosConPromedio();

            // Crear nuevo documento
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Título del reporte
            $sheet->setCellValue('A1', 'REPORTE DE ALUMNOS Y NOTAS');
            $sheet->mergeCells('A1:F1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Fecha de generación
            $sheet->setCellValue('A2', 'Fecha: ' . date('d/m/Y H:i:s'));
            $sheet->mergeCells('A2:F2');
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Encabezados
            $headers = ['ID', 'Nombre', 'Apellido', 'Correo', 'Promedio', 'Resultado'];
            $col = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($col . '4', $header);
                $col++;
            }

            // Estilo de encabezados
            $sheet->getStyle('A4:F4')->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0D6EFD']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                ]
            ]);

            // Datos
            $row = 5;
            foreach ($alumnos as $alumno) {
                $sheet->setCellValue('A' . $row, $alumno['id']);
                $sheet->setCellValue('B' . $row, $alumno['nombre']);
                $sheet->setCellValue('C' . $row, $alumno['apellido']);
                $sheet->setCellValue('D' . $row, $alumno['correo']);
                $sheet->setCellValue('E' . $row, $alumno['promedio'] !== null ? number_format($alumno['promedio'], 2) : '-');
                $sheet->setCellValue('F' . $row, $alumno['resultado']);

                // Color según resultado
                $color = 'FFFFFF';
                switch ($alumno['resultado']) {
                    case 'Sobresaliente':
                        $color = 'D4EDDA';
                        break;
                    case 'Notable':
                        $color = 'CCE5FF';
                        break;
                    case 'Bien':
                        $color = 'D1ECF1';
                        break;
                    case 'Suspenso':
                        $color = 'F8D7DA';
                        break;
                }

                $sheet->getStyle('F' . $row)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => $color]
                    ]
                ]);

                $row++;
            }

            // Bordes para todas las celdas con datos
            $sheet->getStyle('A4:F' . ($row - 1))->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                ]
            ]);

            // Ajustar ancho de columnas
            foreach (range('A', 'F') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Generar archivo
            $filename = 'reporte_alumnos_' . date('Y-m-d_His') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;

        } catch (Exception $e) {
            $_SESSION['mensaje'] = 'Error al generar el reporte: ' . $e->getMessage();
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: reportes.php');
            exit;
        }
    }

    /**
     * Generar reporte en PDF
     */
    public function generarPDF()
    {
        // Verificar que TCPDF esté instalado
        if (!class_exists('TCPDF')) {
            $_SESSION['mensaje'] = 'TCPDF no está instalado. Ejecute: composer install';
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: reportes.php');
            exit;
        }

        try {
            $alumnos = $this->notaModel->getAllAlumnosConPromedio();

            // Crear PDF
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

            // Configuración del documento
            $pdf->SetCreator('Sistema de Gestión de Alumnos');
            $pdf->SetAuthor('Sistema de Gestión');
            $pdf->SetTitle('Reporte de Alumnos y Notas');
            $pdf->SetSubject('Reporte de Notas');

            // Configuración de página
            $pdf->SetMargins(15, 15, 15);
            $pdf->SetAutoPageBreak(true, 15);
            $pdf->AddPage();

            // Título
            $pdf->SetFont('helvetica', 'B', 18);
            $pdf->Cell(0, 10, 'REPORTE DE ALUMNOS Y NOTAS', 0, 1, 'C');

            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(0, 5, 'Fecha: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
            $pdf->Ln(5);

            // Tabla
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->SetFillColor(13, 110, 253);
            $pdf->SetTextColor(255, 255, 255);

            // Encabezados
            $pdf->Cell(15, 7, 'ID', 1, 0, 'C', true);
            $pdf->Cell(35, 7, 'Nombre', 1, 0, 'C', true);
            $pdf->Cell(35, 7, 'Apellido', 1, 0, 'C', true);
            $pdf->Cell(50, 7, 'Correo', 1, 0, 'C', true);
            $pdf->Cell(25, 7, 'Promedio', 1, 0, 'C', true);
            $pdf->Cell(30, 7, 'Resultado', 1, 1, 'C', true);

            // Datos
            $pdf->SetFont('helvetica', '', 9);
            $pdf->SetTextColor(0, 0, 0);

            foreach ($alumnos as $alumno) {
                // Color de fondo según resultado
                $fill = false;
                switch ($alumno['resultado']) {
                    case 'Sobresaliente':
                        $pdf->SetFillColor(212, 237, 218);
                        $fill = true;
                        break;
                    case 'Notable':
                        $pdf->SetFillColor(204, 229, 255);
                        $fill = true;
                        break;
                    case 'Bien':
                        $pdf->SetFillColor(209, 236, 241);
                        $fill = true;
                        break;
                    case 'Suspenso':
                        $pdf->SetFillColor(248, 215, 218);
                        $fill = true;
                        break;
                    default:
                        $pdf->SetFillColor(255, 255, 255);
                }

                $pdf->Cell(15, 6, $alumno['id'], 1, 0, 'C', $fill);
                $pdf->Cell(35, 6, $alumno['nombre'], 1, 0, 'L', $fill);
                $pdf->Cell(35, 6, $alumno['apellido'], 1, 0, 'L', $fill);
                $pdf->Cell(50, 6, $alumno['correo'], 1, 0, 'L', $fill);
                $pdf->Cell(25, 6, $alumno['promedio'] !== null ? number_format($alumno['promedio'], 2) : '-', 1, 0, 'C', $fill);
                $pdf->Cell(30, 6, $alumno['resultado'], 1, 1, 'C', $fill);
            }

            // Leyenda
            $pdf->Ln(5);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(0, 5, 'Escala de Calificación:', 0, 1);
            $pdf->SetFont('helvetica', '', 9);
            $pdf->Cell(0, 5, '0 - 4.99: Suspenso  |  5 - 6.99: Bien  |  7 - 8.99: Notable  |  9 - 10: Sobresaliente', 0, 1);

            // Generar PDF
            $filename = 'reporte_alumnos_' . date('Y-m-d_His') . '.pdf';
            $pdf->Output($filename, 'D');
            exit;

        } catch (Exception $e) {
            $_SESSION['mensaje'] = 'Error al generar el PDF: ' . $e->getMessage();
            $_SESSION['tipo_mensaje'] = 'danger';
            header('Location: reportes.php');
            exit;
        }
    }
}
