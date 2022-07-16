<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('history_area');
        Schema::create('history_area', function (Blueprint $table) {
            $table->id();
            $table->integer('area_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('count_record')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
        Schema::table('history_area', function($table) {
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_area');
    }
}
