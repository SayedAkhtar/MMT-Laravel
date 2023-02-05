<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('patient_family_id');
            $table->string('name');
            $table->unsignedBigInteger('specialization_id');
            $table->unsignedBigInteger('hospital_id');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->text('medical_history')->nullable();
            $table->string('preferred_country')->nullable();
            $table->text('medical_report')->nullable();
            $table->string('passport')->nullable();
            $table->string('passport_image')->nullable();
            $table->string('status')->unique();
            $table->string('model')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queries');
    }
}