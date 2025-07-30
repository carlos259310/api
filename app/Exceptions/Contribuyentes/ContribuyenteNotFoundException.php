<?php
// app/Exceptions/ContribuyenteNotFoundException.php
namespace App\Exceptions\Contribuyentes;

use Exception;

class ContribuyenteNotFoundException extends Exception
{
    public function __construct(string $message = "Contribuyente no encontrado")
    {
        parent::__construct($message);
    }
}
