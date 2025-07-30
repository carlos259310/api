<?php
// filepath: d:\laragon\www\api\database\seeders\ContribuyenteSeeder.php

namespace Database\Seeders;

use App\Models\Contribuyente;
use Illuminate\Database\Seeder;

class ContribuyenteSeeder extends Seeder
{
    public function run(): void
    {
        Contribuyente::factory(50)->create();
    }
}