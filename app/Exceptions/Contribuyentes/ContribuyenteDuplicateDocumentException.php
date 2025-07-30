<?php
// app/Exceptions/ContribuyenteNotFoundException.php
namespace App\Exceptions\Contribuyentes;

use Exception;


class ContribuyenteDuplicateDocumentException extends Exception
{
    public function __construct(string $message = "Documento duplicado")
    {
        parent::__construct($message);
    }
}
