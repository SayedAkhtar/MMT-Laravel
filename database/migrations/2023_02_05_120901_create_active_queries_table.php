<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActiveQueriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_queries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('query_id')->nullable();
            $table->text('doctor_response')->nullable();
            $table->text('patient_response')->nullable();
            $table->string('attendant_passport')->nullable();
            $table->string('tickets')->nullable();
            $table->string('medical_visa')->nullable();
            $table->boolean('is_payment_required')->default(false);
            $table->boolean('is_payment_done')->default(false);
            $table->string('country')->nullable();
            $table->string('state')->nullable();
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
        Schema::dropIfExists('active_queries');
    }
}
