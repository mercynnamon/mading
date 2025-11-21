<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToArtikelsTable extends Migration
{
    public function up()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->enum('status', ['draft', 'pending', 'publish'])->default('draft')->change();
        });
    }

    public function down()
    {
        Schema::table('artikel', function (Blueprint $table) {
            $table->enum('status', ['publish'])->default('publish')->change();
        });
    }
}