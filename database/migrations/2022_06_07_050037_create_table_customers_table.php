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
        Schema::dropIfExists('customers');
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id', true);
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
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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
        Schema::dropIfExists('customers');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
