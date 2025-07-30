<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contribuyentes', function (Blueprint $table) {
            $table->bigIncrements('id_contribuyente'); // Autoincrementable
            $table->string('nombres', 60)->nullable();
            $table->string('apellidos', 60)->nullable();
            $table->string('nombre_completo', 120)->nullable();
            $table->unsignedBigInteger('id_tipo_documento');
            $table->string('id_ciudad', 10); // Relación con ciudades
            $table->string('id_departamento', 10); // Relación con departamentos

            $table->string('documento', 20)->nullable();
            $table->string('email', 100)->unique();
            $table->string('telefono', 15);
            $table->string('direccion', 255);

            $table->timestamps();
            // Clave foránea para tipos_documentos
            $table->foreign('id_tipo_documento')
                ->references('id_tipo_documento')
                ->on('tipos_documentos')
                ->onDelete('cascade');



            // Clave foránea para ciudades
            $table->foreign('id_ciudad')
                ->references('id_ciudad')
                ->on('ciudades')
                ->onDelete('cascade');

            // Clave foránea para departamentos
            $table->foreign('id_departamento')
                ->references('id_departamento')
                ->on('departamentos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contribuyentes');
    }
};
