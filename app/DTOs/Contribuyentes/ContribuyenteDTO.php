<?php
// app/DTOs/ContribuyenteDTO.php
namespace App\DTOs\Contribuyentes;

use App\DTOs\Ciudades\CiudadDTO;
use App\DTOs\Departamentos\DepartamentoDTO;
use App\DTOs\TiposDocumentos\TipoDocumentoDTO;

class ContribuyenteDTO
{
    public function __construct(
        public readonly ?int $id_contribuyente = null,
        public readonly string $nombres = '',
        public readonly string $apellidos = '',
        public readonly ?string $nombre_completo = null,
        public readonly string $tipo_documento = '',
        public readonly string $documento = '',
        public readonly string $email = '',
        public readonly string $telefono = '',
        public readonly string $direccion = '',
        public readonly string $ciudad = '',
        public readonly string $departamento = '',
        public readonly ?int $id_tipo_documento = null,
        public readonly ?string $id_ciudad = null,
        public readonly ?string $id_departamento = null,
        public readonly ?\DateTime $created_at = null,
        public readonly ?\DateTime $updated_at = null,
        // Relaciones
        public readonly ?CiudadDTO $ciudadInfo = null,
        public readonly ?DepartamentoDTO $departamentoInfo = null,
        public readonly ?TipoDocumentoDTO $tipoDocumentoInfo = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id_contribuyente: $data['id_contribuyente'] ?? null,
            nombres: $data['nombres'] ?? '',
            apellidos: $data['apellidos'] ?? '',
            nombre_completo: $data['nombre_completo'] ?? null,
            tipo_documento: $data['tipo_documento'] ?? '',
            documento: $data['documento'] ?? '',
            email: $data['email'] ?? '',
            telefono: $data['telefono'] ?? '',
            direccion: $data['direccion'] ?? '',
            ciudad: $data['ciudad'] ?? '',
            departamento: $data['departamento'] ?? '',
            id_tipo_documento: $data['id_tipo_documento'] ?? null,
            id_ciudad: $data['id_ciudad'] ?? null,
            id_departamento: $data['id_departamento'] ?? null,
        );
    }

    public static function fromModel($contribuyente): self
    {
        return new self(
            id_contribuyente: $contribuyente->id_contribuyente,
            nombres: $contribuyente->nombres,
            apellidos: $contribuyente->apellidos,
            nombre_completo: $contribuyente->nombre_completo,
   
            documento: $contribuyente->documento,
            email: $contribuyente->email,
            telefono: $contribuyente->telefono,
            direccion: $contribuyente->direccion,

            id_tipo_documento: $contribuyente->id_tipo_documento,
            id_ciudad: $contribuyente->id_ciudad,
            id_departamento: $contribuyente->id_departamento,
            created_at: $contribuyente->created_at,
            updated_at: $contribuyente->updated_at,
            // Cargar relaciones si están disponibles
            ciudadInfo: $contribuyente->relationLoaded('ciudad') && $contribuyente->ciudad
                ? CiudadDTO::fromModel($contribuyente->ciudad)
                : null,
            departamentoInfo: $contribuyente->relationLoaded('departamento') && $contribuyente->departamento
                ? DepartamentoDTO::fromModel($contribuyente->departamento)
                : null,
            tipoDocumentoInfo: $contribuyente->relationLoaded('tipoDocumento') && $contribuyente->tipoDocumento
                ? TipoDocumentoDTO::fromModel($contribuyente->tipoDocumento)
                : null,

        );
    }

    public function toArray(): array
    {
        $data = [
            'id_contribuyente' => $this->id_contribuyente,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'nombre_completo' => $this->nombre_completo,
           'tipo_documento' => $this->tipoDocumentoInfo?->documento ?? null,
            'documento' => $this->documento,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'ciudad' => $this->ciudadInfo?->ciudad ?? null,
            'departamento' => $this->departamentoInfo?->departamento ?? null,
            'id_tipo_documento' => $this->id_tipo_documento,
            'id_ciudad' => $this->id_ciudad,
            'id_departamento' => $this->id_departamento,
        ];
/* se comenta temporalmente ya que se requieren solo algunos campos en el DTO
        // Agregar relaciones si existen
      
        if ($this->ciudadInfo) {
            $data['ciudad_info'] = $this->ciudadInfo->toArray();
        }

        if ($this->departamentoInfo) {
            $data['departamento_info'] = $this->departamentoInfo->toArray();
        }

        if ($this->tipoDocumentoInfo) {
            $data['tipo_documento_info'] = $this->tipoDocumentoInfo->toArray();
        }
*/
        return $data;
    }
}
