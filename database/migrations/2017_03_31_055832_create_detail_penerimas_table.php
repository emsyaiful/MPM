<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailPenerimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_penerimas', function (Blueprint $table) {
            $table->uuid('id_detail_penerima')->index();
            $table->uuid('user_id');
            $table->uuid('questionare_id');
            $table->integer('status')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->primary('id_detail_penerima');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('detail_penerimas');
    }
}
