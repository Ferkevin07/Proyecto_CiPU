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
        Schema::create('managers', function (Blueprint $table) {
            //ID para la tabla BDD
            $table->id();
            //nombre admin
            $table->string('first_name',30);
            //apellido admin
            $table->string('last_name',30);
            //nombre de usuario admin
            $table->string('username',30);

            //correo admin
            $table->string('email')->unique();
            //telefono admin
            $table->string('personal_phone',10);
            //telefono convencional admin
            $table->string('home_phone',9);
            //direccion admin
            $table->string('address',50);
            //fecha de nacimiento admin
            $table->date('birthdate')->nullable();

            //estado de admin
            $table->boolean('state')->default(true);

            //Creacion de cuenta bd
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            //Relacion
            $table->unsignedBigInteger('role_id');
            //un rol puede tener uno o varios adminstradores y un administrador le pertenece a un rol
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
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
        Schema::dropIfExists('managers');
    }
};
