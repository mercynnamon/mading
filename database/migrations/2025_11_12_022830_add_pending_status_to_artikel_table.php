<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPendingStatusToArtikelTable extends Migration
{
    public function up()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('artikel', function (Blueprint $table) {
            $table->enum('status', ['draft', 'pending', 'publish'])->default('pending');
        });
    }

    public function down()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('artikel', function (Blueprint $table) {
            $table->enum('status', ['draft', 'publish'])->default('publish');
        });
    }
}