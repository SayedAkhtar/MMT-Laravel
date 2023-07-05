<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecializationToPatientDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_family_details', function (Blueprint $table) {
            $table->unsignedBigInteger('speciality')->nullable();
            $table->foreign('speciality')->references('id')->on('specializations')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_family_details', function (Blueprint $table) {
            $table->dropForeign('patient_family_details_speciality_foreign');
            $table->dropColumn(['speciality']);
        });
    }
}
