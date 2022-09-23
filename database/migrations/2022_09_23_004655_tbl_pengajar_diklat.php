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

        Schema::create('tbl_pengajar_diklat', function (Blueprint $table) {
            $table->id();
            $table->integer('id_diklat');
            $table->integer('id_pengajar');
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
        Schema::dropIfExists('tbl_pengajar_diklat');
    }
};
