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
            $table->unsignedBigInteger('patient_family_id')->nullable();
            $table->unsignedBigInteger('specialization_id')->nullable()->default(null);
            $table->unsignedBigInteger('hospital_id')->nullable()->default(null);
            $table->unsignedBigInteger('doctor_id')->nullable()->default(null);
            $table->enum('type', [1, 2])->comment('1 => For Queries, 2 => For Medical visa applications')->default(1);
            $table->integer('current_step')->default(1);
            $table->string('status');
            $table->boolean('payment_required')->default(false);
            $table->text('confirmed_details')->default(null);
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
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
