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
            $table->string('so_thu_tu')->nullable();
            $table->string('vpbank')->nullable();
            $table->string('msdl')->nullable();;
            $table->string('cv')->nullable();;
            $table->string('so_hop_dong')->unique();
            $table->string('menh_gia')->nullable();
            $table->string('nam_dao_han')->nullable();
            $table->string('ten_kh')->nullable();
            $table->string('gioi_tinh')->nullable();
            $table->string('ngay_sinh')->nullable();
            $table->string('tuoi')->nullable();
            $table->string('dien_thoai')->nullable();
            $table->string('dia_chi_cu_the')->nullable();
            $table->string('comment')->nullable();
            $table->integer('type_result')->nullable();
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
