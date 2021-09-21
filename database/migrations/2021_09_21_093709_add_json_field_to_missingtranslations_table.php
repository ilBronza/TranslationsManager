<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJsonFieldToMissingtranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('missingtranslations', function (Blueprint $table) {
            $table->text('data')->nullable();
            $table->text('args')->nullable();
            $table->string('file', 512)->nullable();
            $table->string('line', 12)->nullable();
            $table->string('method', 64)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('missingtranslations', function (Blueprint $table) {
            $table->dropColumn('data');
            $table->dropColumn('argsh');
            $table->dropColumn('file');
            $table->dropColumn('line');
            $table->dropColumn('method');
        });
    }
}
