<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('komentars', function (Blueprint $table) {
            $table->bigIncrements('id_komentar');
            $table->text('isi');
            $table->unsignedBigInteger('id_artikel');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->index('id_artikel');
            $table->index('id_user');
        });
    }

    public function down()
    {
        Schema::dropIfExists('komentars');
    }
};