<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('areas_customers');
        Schema::create('areas_customers', function (Blueprint $table) {
            $table->bigIncrements('id', true)->index();
            $table->integer('user_id')->unsigned()->nullable();
            $table->bigInteger('area_id')->unsigned()->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->string('type_call')->nullable();
            $table->string('called')->nullable();
            $table->string('so_thu_tu')->nullable();
            $table->string('vpbank')->nullable();
            $table->string('msdl')->nullable();
            $table->string('cv')->nullable();
            $table->string('so_hop_dong')->unique();
            $table->string('menh_gia')->nullable();
            $table->string('nam_dao_han')->nullable();
            $table->string('ho')->nullable();
            $table->string('ten')->nullable();
            $table->string('ten_kh')->nullable();
            $table->string('gioi_tinh')->nullable();
            $table->string('ngay_sinh')->nullable();
            $table->string('tuoi')->nullable();
            $table->string('dien_thoai')->nullable();
            $table->text('comment')->nullable();
            $table->string('dia_chi_cu_the')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::table('areas_customers', function($table) {
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('areas_customers', function(Blueprint $table) {
            $table->index(['user_id', 'area_id', 'so_hop_dong']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('areas_customers');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
