<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailQuestionaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_questionares', function (Blueprint $table) {
            $table->uuid('id_detail_questionare')->index();
            $table->uuid('questionare_id');
            $table->string('pertanyaan');
            $table->integer('jenis_pertanyaan');
            $table->integer('urutan');
            $table->integer('jumlah')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->primary('id_detail_questionare');

            $table->foreign('questionare_id')->references('id_questionare')->on('questionares');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_questionares');
    }
}
