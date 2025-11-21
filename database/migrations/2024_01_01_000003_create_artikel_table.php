<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->bigIncrements('id_artikel');
            $table->string('judul');
            $table->text('konten');
            $table->string('foto')->nullable();
            $table->enum('status', ['draft', 'pending', 'publish', 'rejected'])->default('draft');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_kategori');
            $table->timestamps();

            $table->index('id_user');
            $table->index('id_kategori');
        });
    }

    public function down()
    {
        Schema::dropIfExists('artikel');
    }
};