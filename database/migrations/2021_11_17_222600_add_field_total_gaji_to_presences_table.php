<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldTotalGajiToPresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->integer('uang_kehadiran')->after('periode');
            $table->integer('uang_lebih_jam')->after('uang_kehadiran');
            $table->integer('uang_insentif')->after('uang_lebih_jam');
            $table->integer('total_gaji')->after('employee_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->dropColumn('total_gaji');
            $table->dropColumn('uang_kehadiran');
            $table->dropColumn('uang_lebih_jam');
            $table->dropColumn('uang_insentif');
        });
    }
}
