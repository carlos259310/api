<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ContribuyenteReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdf\Fpdf; // Para crear PDFs desde cero

class ContribuyenteReportController extends Controller
{
    public function __construct(private ContribuyenteReportService $reportService) 
    {
      //  $this->middleware('auth:api');
    }

    public function generateContribuyentesReport(Request $request)
    {
        $request->validate([
            'type' => 'required|in:pdf,xlsx'
        ]);

        try {
            $report = $this->reportService->generateContribuyentesReport(
                $request->type,
                $request->only(['search', 'per_page', 'with_relations'])
            );

            return response()->json([
                'success' => true,
                'message' => 'Reporte generado exitosamente',
                'data' => $report
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar reporte',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function downloadReport(string $path)
    {
        if (!Storage::disk('reports')->exists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'El reporte solicitado no existe'
            ], 404);
        }

        return Storage::disk('reports')->download($path);
    }
}