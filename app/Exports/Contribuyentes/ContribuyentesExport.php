<?php

namespace App\Exports\Contribuyentes;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ContribuyentesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $contribuyentes;

    public function __construct($contribuyentes)
    {
        $this->contribuyentes = $contribuyentes;
    }

    public function collection()
    {
        return $this->contribuyentes;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombres',
            'Apellidos',
            'Documento',
            'Email',
            'Teléfono',
            'Dirección',
            'Tipo Documento',
            'Ciudad',
            'Departamento',
            'Fecha Registro'
        ];
    }

    public function map($contribuyente): array
    {
        return [
            $contribuyente->id_contribuyente,
            $contribuyente->nombres,
            $contribuyente->apellidos,
            $contribuyente->documento,
            $contribuyente->email,
            $contribuyente->telefono,
            $contribuyente->direccion,
            $contribuyente->tipoDocumentoInfo->documento ?? 'N/A',
            $contribuyente->ciudadInfo->ciudad ?? 'N/A',
            $contribuyente->departamentoInfo->departamento ?? 'N/A',
            $contribuyente->created_at->format('d/m/Y H:i')
        ];
    }
}
