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
        Schema::create('product_provider', function (Blueprint $table) {
            //ID para la tabla
            $table->id();

            //columna para la tabla bd
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('product_id');
            $table->boolean('state')->default(true);

            //Relacion
            //un proveedor puede estar muchos productos
            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            //un producto puede tener muchos proveedores
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('provider_product');
    }
};
