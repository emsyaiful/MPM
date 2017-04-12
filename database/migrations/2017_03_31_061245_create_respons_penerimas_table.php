<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResponsPenerimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respons_penerimas', function (Blueprint $table) {
            $table->uuid('id_respons_penerima')->index();
            $table->uuid('user_id');
            $table->uuid('questionare_id');
            $table->uuid('detail_questionare_id');
            $table->string('response')->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->string('image5')->nullable();
            $table->string('image6')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('deleted_at')->nullable();

            $table->primary('id_respons_penerima');

            $table->foreign('detail_questionare_id')->references('id_detail_questionare')->on('detail_questionares');
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
        Schema::dropIfExists('respons_penerimas');
    }
}
