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
        Schema::create('debts', function (Blueprint $table) {
            //ID para la tabla BDD
            $table->id();
            //deuda para pagar
            $table->boolean('to_pay')->default(false);
            //deuda para pagar
            $table->boolean('to_collect')->default(false);
            //precio deuda
            $table->float('price',8,2);
            //deuda para pagar
            $table->string('details',60);
            //estado de la deuda
            $table->boolean('state')->default(false);

            //Relacion
            $table->unsignedBigInteger('user_id')->nullable();
            //un usuario puede tener una deuda y una deuda le pertenece a un usuario
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            /* //Relacion
            $table->unsignedBigInteger('client_id')->nullable();
            //un administrador puede tener una deuda y una deuda le pertenece a un administrador
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade')
                ->onUpdate('cascade'); */

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
        Schema::dropIfExists('debts');
    }
};
