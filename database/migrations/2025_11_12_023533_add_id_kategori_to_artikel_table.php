<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdKategoriToArtikelTable extends Migration
{
    public function up()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
            $table->dropColumn('id_kategori');
        });
    }
}