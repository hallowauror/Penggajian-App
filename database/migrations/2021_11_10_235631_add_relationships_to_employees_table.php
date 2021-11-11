<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->unsignedBigInteger('position_id')->unsigned()->change();
            $table->foreign('position_id')->references('id')->on('positions')
                    ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_position_id_foreign');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dropIndex('employees_position_id_foreign');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->bigInteger('position_id')->change();
        });

    }
}
