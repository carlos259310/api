<?php

namespace App\Providers;

use App\Contracts\Repositories\CiudadRepositoryInterface;
use App\Contracts\Repositories\ContribuyenteRepositoryInterface;
use App\Contracts\Repositories\DepartamentoRepositoryInterface;
use App\Contracts\Repositories\ProductoRepositoryInterface;
use App\Contracts\Repositories\TipoDocumentoRepositoryInterface;
use App\Repositories\CiudadRepository;
use App\Repositories\ContribuyenteRepository;
use App\Repositories\DepartamentoRepository;
use App\Repositories\ProductoRepository;
use App\Repositories\TipoDocumentoRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Repository de Productos
        $this->app->bind(
            ProductoRepositoryInterface::class,
            ProductoRepository::class
        );

        // Repository de Contribuyentes
        $this->app->bind(
            ContribuyenteRepositoryInterface::class,
            ContribuyenteRepository::class
        );

        //ciudades
        $this->app->bind(
            CiudadRepositoryInterface::class,
            CiudadRepository::class
        );

        //departamentos
        $this->app->bind(
            DepartamentoRepositoryInterface::class,
            DepartamentoRepository::class
        );

        //tipos documentos
        $this->app->bind(
            TipoDocumentoRepositoryInterface::class,
            TipoDocumentoRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
