<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_customer', function (Blueprint $table) {
            $table->id();
            $table->string('type_pay')->nullable();
            $table->string('name_pay')->nullable();
            $table->string('id_customer_pay')->nullable();;
            $table->string('position')->nullable();;
            $table->string('id_contract');
            $table->string('join_date');
            $table->string('note')->nullable();
            $table->string('money');
            $table->string('date_due_full');
            $table->string('date_due')->nullable();
            $table->string('month_due')->nullable();
            $table->string('year_due')->nullable();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('sex');
            $table->string('date_birth');
            $table->string('age');
            $table->string('phone');
            $table->string('address_full');
            $table->string('home');
            $table->string('ward');
            $table->string('district');
            $table->string('province');
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
        Schema::dropIfExists('table_customer');
    }
}
