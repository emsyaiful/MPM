<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            // $table->increments('id');
            $table->uuid('id');
            $table->string('name', 60);
            $table->string('email', 30)->unique();
            $table->string('password', 60);
            $table->integer('user_status');
            $table->uuid('division_id')->nullable();
            $table->uuid('dealer_id')->nullable();
            $table->integer('is_active')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->rememberToken();
            // $table->timestamps();

            $table->primary('id');

            // $table->foreign('role_id')->references('id_role')->on('user_roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
