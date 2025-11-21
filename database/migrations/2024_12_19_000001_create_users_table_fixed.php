<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('users');
        
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id_user', true); // Auto increment primary key
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'guru', 'siswa'])->default('siswa');
            $table->timestamps();
            
            $table->primary('id_user');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};