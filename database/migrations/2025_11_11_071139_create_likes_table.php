<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    public function up()
    {
        Schema::create('like', function (Blueprint $table) {
            $table->id('id_like');
            $table->unsignedBigInteger('id_artikel');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_artikel')->references('id_artikel')->on('artikel')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');

            // Agar satu user hanya bisa like sekali per artikel
            $table->unique(['id_artikel', 'id_user']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('like');
    }
}