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
        Schema::table('addon', function (Blueprint $table) {
            $table->integer('id_template_pertanyaan')->index()->after('id');
            $table->renameColumn('tipe_addon', 'addon');
            $table->string('default')->nullable()->after('addon');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addon', function (Blueprint $table) {
            //
        });
    }
};
