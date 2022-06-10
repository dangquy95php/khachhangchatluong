<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('type_pay')->nullable();
            $table->string('name_pay')->nullable();
            $table->string('id_customer_pay')->nullable();;
            $table->string('position')->nullable();;
            $table->string('id_contract');
            $table->string('join_date')->nullable();
            $table->string('note')->nullable();
            $table->string('money')->nullable();
            $table->string('date_due_full')->nullable();
            $table->string('date_due')->nullable();
            $table->string('month_due')->nullable();
            $table->string('year_due')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('sex')->nullable();
            $table->string('date_birth')->nullable();
            $table->string('age')->nullable();
            $table->string('phone')->nullable();
            $table->string('address_full')->nullable();
            $table->string('home')->nullable();
            $table->string('ward')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->boolean('by_area')->default(0);
            $table->string('info_option')->nullable(0);
            $table->text('comment')->nullable(0);
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
        Schema::dropIfExists('customers');
    }
}
