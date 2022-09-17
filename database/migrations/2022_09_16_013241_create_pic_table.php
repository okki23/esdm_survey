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
        Schema::create('pic', function (Blueprint $table) {
            $table->id();
            $table->integer('id_unit')->index();
            $table->string('nama_pic', 100);
            $table->string('telp', 15);
            $table->smallInteger('created_by')->nullable()->default(1);
            $table->smallInteger('updated_by')->nullable()->default(1);
            $table->smallInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pic');
    }
};
