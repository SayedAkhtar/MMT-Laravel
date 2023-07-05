<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->references('id')->on('doctors');
            $table->foreignId('patient_id')->references('id')->on('patient_details');
            $table->integer('scheduled_at');
            $table->text('messages')->nullable()->default(null);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_completed')->default(false);
            $table->bigInteger('payment_id')->nullable()->default(null);
            $table->enum('payment_status', ['COMPLETED', 'PENDING', 'FAILED', 'STARTED'])->default('PENDING');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_consultations');
    }
}
