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
        Schema::create('aspek_pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kategori')->index();
            $table->tinyText('pertanyaan');
            $table->integer('id_tipe_kuis')->index();
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
        Schema::dropIfExists('aspek_pertanyaan');
    }
};
