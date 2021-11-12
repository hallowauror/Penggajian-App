<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToPresencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presences', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->unsigned()->change();
            $table->foreign('employee_id')->references('id')->on('employees')
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
        Schema::table('presences', function (Blueprint $table) {
            $table->dropForeign('presences_employee_id_foreign');
        });
        Schema::table('presences', function (Blueprint $table) {
            $table->dropIndex('presences_employee_id_foreign');
        });
        Schema::table('presences', function (Blueprint $table) {
            $table->bigInteger('employee_id')->change();
        });

        
    }
}
