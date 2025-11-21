<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomentarsTable extends Migration
{
    public function up()
    {
        Schema::create('komentar', function (Blueprint $table) {
            $table->id('id_komentar');
            $table->unsignedBigInteger('id_artikel');
            $table->unsignedBigInteger('id_user');
            $table->text('isi');
            $table->timestamps();

            $table->foreign('id_artikel')->references('id_artikel')->on('artikel')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('komentar');
    }
}