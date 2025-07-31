<?php

namespace App\Services;

use App\Contracts\Repositories\ContribuyenteRepositoryInterface;
use App\Exports\Contribuyentes\ContribuyentesExport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;



class ContribuyenteReportService
{
    private $contribuyenteRepository;

    public function __construct(ContribuyenteRepositoryInterface $contribuyenteRepository)
    {
        $this->contribuyenteRepository = $contribuyenteRepository;
    }

    public function generateContribuyentesReport(string $type, array $filters = [])
    {
        $perPage = $filters['per_page'] ?? 15;
        $search = $filters['search'] ?? null;
        $withRelations = $filters['with_relations'] ?? true;

        if ($search) {
            $contribuyentes = $this->contribuyenteRepository->search($search, $perPage, $withRelations);
        } else {
            $contribuyentes = $this->contribuyenteRepository->getAll($perPage, $withRelations);
        }

        $fileName = 'contribuyentes_' . now()->format('Ymd_His') . '.' . $type;
        $path = "reports/{$fileName}";

        if ($type === 'xlsx') {
            Excel::store(
                new ContribuyentesExport($contribuyentes->getCollection()),
                $path,
                'reports'
            );
        } elseif ($type === 'pdf') {
            require_once base_path('vendor/setasign/fpdf/fpdf.php');
            $pdf = new \FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 16);

            // Encabezado con título y línea
            $pdf->SetTextColor(40, 40, 40);
            $pdf->Cell(0, 12, mb_convert_encoding('Reporte de Contribuyentes', 'ISO-8859-1', 'UTF-8'), 0, 1, 'C');
            $pdf->SetDrawColor(100, 100, 100);
            $pdf->Line(10, 25, 200, 25);
            $pdf->Ln(8);

            // Cabecera de la tabla
            $pdf->SetFont('Arial', 'B', 11);
            $pdf->SetFillColor(220, 220, 220);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(15, 8, 'ID', 1, 0, 'C', true);
            $pdf->Cell(35, 8, 'Nombres', 1, 0, 'C', true);
            $pdf->Cell(35, 8, 'Apellidos', 1, 0, 'C', true);
            $pdf->Cell(30, 8, 'Documento', 1, 0, 'C', true);
            $pdf->Cell(70, 8, 'Email', 1, 0, 'C', true);
            $pdf->Ln();

            // Filas alternando color
            $pdf->SetFont('Arial', '', 10);
            $fill = false;
            foreach ($contribuyentes->getCollection() as $c) {
                $pdf->SetFillColor($fill ? 245 : 255, $fill ? 245 : 255, $fill ? 245 : 255);
                $pdf->Cell(15, 7, $c->id_contribuyente ?? '', 1, 0, 'C', true);

                $pdf->Cell(35, 7, mb_convert_encoding($c->nombres ?? '', 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', true);
                $pdf->Cell(35, 7, mb_convert_encoding($c->apellidos ?? '', 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', true);
                $pdf->Cell(30, 7, mb_convert_encoding($c->documento ?? '', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C', true);
                $pdf->Cell(70, 7, mb_convert_encoding($c->email ?? '', 'ISO-8859-1', 'UTF-8'), 1, 0, 'L', true);
                $pdf->Ln();
                $fill = !$fill;
            }

            // Pie de página
            $pdf->SetY(-20);
            $pdf->SetFont('Arial', 'I', 9);
            $pdf->SetTextColor(120, 120, 120);
            $pdf->Cell(0, 10, 'Generado el ' . date('d/m/Y H:i'), 0, 0, 'R');

            $pdfContent = $pdf->Output('S');
            Storage::disk('reports')->put($path, $pdfContent);
        } else {
            throw new \InvalidArgumentException("Tipo de reporte no válido: {$type}");
        }

        return [
            'path' => $path,
            'url' => route('api.reports.download', ['path' => $path]),
            'size' => Storage::disk('reports')->size($path),
            'type' => $type
        ];
    }
}
