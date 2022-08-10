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
        Schema::create('comments', function (Blueprint $table) {
            //ID para la tabla BDD
            $table->id();
            //detalle comentario
            $table->string('details',80);
            //estado de revisado de comentario
            $table->boolean('state')->default(true);
            //ranking de comentario
            $table->string('ranking')->default(1);
            //numero
            //enum('difficulty', ['low', 'high'])->default('low');

            /* //relacion
            $table->unsignedBigInteger('client_id');
            //un usuario puede tener uno o mas comentarios y un comentario le pertenece a un usuario
            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('cascade')
                ->onUpdate('cascade'); */

            //relacion
            $table->unsignedBigInteger('user_id');
            //un usuario puede tener uno o mas comentarios y un comentario le pertenece a un usuario
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
        Schema::dropIfExists('comments');
    }
};
