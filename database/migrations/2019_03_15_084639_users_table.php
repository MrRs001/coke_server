<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * User fields
         * id
         * user name
         * password
         * access token to validate
         */
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 50);
            $table->string('password', 200);
            $table->string('token', 200)->nullable();
            $table->timestamps();
        });

        /**
         * Data note
         * Title
         * Desc
         * create_user
         */
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('desc', 300);
            $table->string('creator', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
