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
        Schema::create('orders', function (Blueprint $table) {
            //ID para la tabla BDD
            $table->id();
            //nombre pedido
            $table->string('name',30);
            //estado pedido
            $table->boolean('state')->default(true);
            //detalles pedido
            $table->string('details',60);

            /*  //relacion
             $table->unsignedBigInteger('client_id');
             //un usuario puede tener uno o mas pedidos y un pedido le pertenece a un usuario
             $table->foreign('client_id')
                 ->references('id')
                 ->on('clients')
                 ->onDelete('cascade')
                 ->onUpdate('cascade'); */
            
            //relacion
            $table->unsignedBigInteger('user_id');
            //un usuario puede tener uno o mas pedidos y un pedido le pertenece a un usuario
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('orders');
    }
};
