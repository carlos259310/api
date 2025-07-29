<?php
// app/Exceptions/ProductoNotFoundException.php
namespace App\Exceptions;

use Exception;

class ProductoNotFoundException extends Exception
{
    public function __construct(string $message = "Producto no encontrado")
    {
        parent::__construct($message);
    }
}
