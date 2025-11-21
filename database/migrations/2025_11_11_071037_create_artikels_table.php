<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelsTable extends Migration
{
    public function up()
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id('id_artikel');
            $table->string('judul');
            $table->text('konten');
            $table->string('foto')->nullable(); // path gambar
            $table->enum('status', ['draft', 'publish'])->default('publish');
            $table->unsignedBigInteger('id_user'); // penulis
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('artikel');
    }
}