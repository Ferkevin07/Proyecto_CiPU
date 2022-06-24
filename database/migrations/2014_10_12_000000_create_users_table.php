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
        Schema::create('users', function (Blueprint $table) {
            //ID para la tabla BDD
            $table->id();
            //Datos personales para la bd
            $table->string('first_name',30)->nullable();;
            $table->string('last_name',30)->nullable();
            $table->string('username',50)->nullable();
            $table->string('personal_phone',11)->nullable();
            $table->string('home_phone',10)->nullable();
            $table->string('address',50)->nullable();          
            $table->string('email')->unique();
            
            //estado de usuario
            $table->boolean('state')->default(true);
            //fecha de nacimiento usuario
            $table->date('birthdate')->nullable();

            //Creacion de cuenta bd
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

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
        Schema::dropIfExists('users');
    }
};
