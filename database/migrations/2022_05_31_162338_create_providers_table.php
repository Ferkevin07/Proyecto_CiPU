<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            //ID para la tabla BDD
            $table->id();

            //Nombre de la empresa de proveedor
            $table->string('name',50);
            //Nombre del proveedor
            $table->string('first_name',30);
            //Apellido del proveedor
            $table->string('last_name',30);

            //Direccion proveedor
            $table->string('direction',60);
            //Descripcion proveedor
            $table->string('description',60)->nullable();
            //estado del proveedor
            $table->boolean('state')->default(true);
            
            //columnas de CREACION/ACTUALIZACION para la BDD
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('providers');
    }
};
