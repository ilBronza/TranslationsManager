<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('missingtranslations', function (Blueprint $table) {
            $table->string('scope', 128)->nullable()->before('filename');
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
            $table->dropColumn('scope');
        });
    }
};
