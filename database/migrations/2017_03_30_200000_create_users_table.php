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
            $table->integer('role_id')->unsigned();
            $table->string('name', 60);
            $table->string('email', 30)->unique();
            $table->string('password', 60);
            $table->string('alamat');
            $table->integer('is_active')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('deleted_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->rememberToken();
            // $table->timestamps();

            $table->primary('id');

            $table->foreign('role_id')->references('id_role')->on('user_roles');
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
