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
                $table->string('type');
                $table->dateTime('expired_at')->nullable();
                $table->timestamps();
            });
       }
        
        if(!Schema::hasTable('Customer')){
            Schema::create('Customer', function (Blueprint $table) {
                $table->increments('id')->unique();
                $table->string('customer_code')->nullable();
                $table->string('name')->nullable();
                $table->string('sales_office')->nullable();
                $table->string('distribute_code')->nullable();
                $table->string('city')->nullable();
                $table->string('district')->nullable();
                $table->string('street')->nullable();
                $table->string('contact_first_name')->nullable();
                $table->string('sales_rep')->nullable();
                $table->string('telephone')->nullable();
                $table->string('mobile')->nullable();
                $table->string('trade_channel')->nullable();
                $table->string('customer_category')->nullable();
                $table->string('sub_trade_channel')->nullable();
                $table->string('key_acc')->nullable();
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('Gift')){
            Schema::create('Gift', function (Blueprint $table) {
                $table->increments('id')->unique();
                
                $table->string('name')->nullable();

                $table->string('image')->nullable();
                $table->float('price')->nullable();
                
                $table->integer('total_amount')->nullable();
                $table->integer('current_amount')->nullable();
                
                $table->float('percent_default')->nullable();
                $table->float('current_percent')->nullable();
                $table->string('type')->nullable();
                $table->timestamps();
            });
        }

        if(!Schema::hasTable('ContractInfo')){
            Schema::create('ContractInfo', function (Blueprint $table) {
                $table->increments('id')->unique();
                $table->string('contract_id')->unique();
                $table->string('distribute_code');
                $table->string('sales');
                $table->string('image')->nullable();
                $table->string('hash_image')->nullable();
                $table->string('gift_id')->nullable();
                $table->string('gift_type')->nullable();
                $table->string('u_name')->nullable();
                $table->string('u_phone')->nullable();
                $table->string('u_address')->nullable();
                $table->string('u_img')->nullable();
                $table->string('u_identity_card')->nullable();
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
