<?php
// app/Exceptions/ContribuyenteNotFoundException.php
namespace App\Exceptions\Contribuyentes;

use Exception;

class ContribuyenteDuplicateEmailException extends Exception
{
    public function __construct(string $message = "Email duplicado")
    {
        parent::__construct($message);
    }
}
