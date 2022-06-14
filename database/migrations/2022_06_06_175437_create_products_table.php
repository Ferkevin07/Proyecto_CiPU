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
        Schema::create('products', function (Blueprint $table) {
            //ID para la tabla BDD
            $table->id();
            //nombre producto
            $table->string('name',30);
            //stock producto
            $table->integer('stock');
            //descripcion producto
            $table->string('description',60);
            //precio minimo producto
            $table->float('price_min',8,2);
            //precio maximo producto
            $table->float('price_max',8,2);

            //relacion
            $table->unsignedBigInteger('type_id');
            //un tipo puede tener uno o mas productos y un producto le pertenece a un tipo
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
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
        Schema::dropIfExists('products');
    }
};
