<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropForeignSpecializationOnQueries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('queries', function (Blueprint $table) {
            $table->dropForeign('queries_specialization_id_foreign');
            $table->dropForeign('queries_hospital_id_foreign');
            $table->dropForeign('queries_doctor_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
