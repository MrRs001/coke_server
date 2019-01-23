<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAndAddForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('User')) {
            Schema::create('User', function (Blueprint $table) {
                $table->increments('id')->unique();
                $table->string('user_id');
                $table->string('password');
                $table->timestamps();
            });
       }
       
        if(!Schema::hasTable('Customers')){
            Schema::create('Customers', function (Blueprint $table) {
                $table->increments('id')->unique();
                $table->string('contract_id');
                $table->string('voucher_id');
                $table->string('user_id');
                $table->string('image');
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('Gift')){
            Schema::create('Gift', function (Blueprint $table) {
                $table->increments('id')->unique();
                $table->string('name');
                $table->string('image');
                $table->integer('persent');
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('CustomerHaveGift')){
            Schema::create('CustomerHaveGift', function (Blueprint $table) {
                $table->increments('id')->unique();
                $table->string('contract');
                $table->string('gift');
                $table->timestamps();
            });
        }
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
