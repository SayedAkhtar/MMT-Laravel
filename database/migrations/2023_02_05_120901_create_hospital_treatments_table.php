<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospital_treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hospital_id');
            $table->unsignedBigInteger('treatment_id');
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hospital_treatments');
    }
}