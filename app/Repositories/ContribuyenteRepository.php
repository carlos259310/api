<?php
// app/Repositories/ContribuyenteRepository.php
namespace App\Repositories;

use App\Contracts\Repositories\ContribuyenteRepositoryInterface;
use App\DTOs\Contribuyentes\ContribuyenteDTO;
use App\DTOs\Contribuyentes\CreateContribuyenteDTO;
use App\DTOs\Contribuyentes\UpdateContribuyenteDTO;
use App\Models\Contribuyente;
use Illuminate\Pagination\LengthAwarePaginator;

class ContribuyenteRepository implements ContribuyenteRepositoryInterface
{
    public function __construct(
        private readonly Contribuyente $model
    ) {}

    public function getAll(int $perPage = 15, bool $withRelations = false): LengthAwarePaginator
    {
        $query = $this->model->orderBy('created_at', 'desc');

        if ($withRelations) {
            $query->with(['ciudad', 'departamento', 'tipoDocumento']);
        }

        $paginator = $query->paginate($perPage);
        // Mapear cada modelo a DTO
        $paginator->getCollection()->transform(function ($contribuyente) {
            return ContribuyenteDTO::fromModel($contribuyente);
        });

        return $paginator;
    }

    public function findById(int $id, bool $withRelations = false): ?ContribuyenteDTO
    {
        $query = $this->model->where('id_contribuyente', $id);

        if ($withRelations) {
            $query->with(['ciudad', 'departamento', 'tipoDocumento']);
        }

        $contribuyente = $query->first();

        return $contribuyente ? ContribuyenteDTO::fromModel($contribuyente) : null;
    }

    public function findByDocument(string $documento): ?ContribuyenteDTO
    {
        $contribuyente = $this->model
            ->with(['ciudad', 'departamento', 'tipoDocumento'])
            ->where('documento', $documento)
            ->first();

        return $contribuyente ? ContribuyenteDTO::fromModel($contribuyente) : null;
    }

    public function findByEmail(string $email): ?ContribuyenteDTO
    {
        $contribuyente = $this->model
            ->with(['ciudad', 'departamento', 'tipoDocumento'])
            ->where('email', $email)
            ->first();

        return $contribuyente ? ContribuyenteDTO::fromModel($contribuyente) : null;
    }

    public function create(CreateContribuyenteDTO $dto): ContribuyenteDTO
    {
        //$contribuyente = $this->model->create($dto->toArray());
        $data = [
            'nombres' => $dto->nombres,
            'apellidos' => $dto->apellidos,
            'nombre_completo' => $dto->nombres . ' ' . $dto->apellidos, // Generar automáticamente
            'documento' => $dto->documento,
            'email' => $dto->email,
            'telefono' => $dto->telefono,
            'direccion' => $dto->direccion,
            'id_tipo_documento' => $dto->id_tipo_documento,
            'id_ciudad' => $dto->id_ciudad,
            'id_departamento' => $dto->id_departamento,
        ];
        $contribuyente = $this->model->create($data);

        // Cargar relaciones
        $contribuyente->load(['ciudad', 'departamento', 'tipoDocumento']);

        return ContribuyenteDTO::fromModel($contribuyente);
    }

    public function update(int $id, UpdateContribuyenteDTO $dto): ?ContribuyenteDTO
    {
        $contribuyente = $this->model->find($id);

        if (!$contribuyente) {
            return null;
        }

        $contribuyente->update($dto->toArray());

        // Cargar relaciones
        $contribuyente->load(['ciudad', 'departamento', 'tipoDocumento']);

        return ContribuyenteDTO::fromModel($contribuyente);
    }

    public function delete(int $id): bool
    {
        $contribuyente = $this->model->find($id);

        return $contribuyente ? $contribuyente->delete() : false;
    }

    public function search(string $query, int $perPage = 15, bool $withRelations = false): LengthAwarePaginator
    {
        $queryBuilder = $this->model
            ->where('nombres', 'LIKE', "%{$query}%")
            ->orWhere('apellidos', 'LIKE', "%{$query}%")
            ->orWhere('nombre_completo', 'LIKE', "%{$query}%")
            ->orWhere('documento', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orderBy('created_at', 'desc');

        if ($withRelations) {
            $queryBuilder->with(['ciudad', 'departamento', 'tipoDocumento']);
        }

        return $queryBuilder->paginate($perPage);
    }

    public function getByCity(string $cityId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['ciudad', 'departamento', 'tipoDocumento'])
            ->where('id_ciudad', $cityId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getByDepartment(string $departmentId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['ciudad', 'departamento', 'tipoDocumento'])
            ->where('id_departamento', $departmentId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getByDocumentType(int $documentTypeId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['ciudad', 'departamento', 'tipoDocumento'])
            ->where('id_tipo_documento', $documentTypeId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
