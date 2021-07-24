<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMultiStepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('multi_step', function (Blueprint $table) {
            $table->unsignedBigInteger('master_id')->default(1)->index();
			$table->string('button_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('multi_step', function (Blueprint $table) {
            $table->dropcolumn('master_id');
            $table->dropcolumn('button_text');
        });
    }
}
