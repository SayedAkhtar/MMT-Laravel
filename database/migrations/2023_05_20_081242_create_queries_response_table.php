<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueriesResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('query_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('query_id')->references('id')->on('queries')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('step', [1, 2, 3, 4, 5])->unique()
                ->comment('1 => Query Basic Information
                                    2 => Doctor Reply
                                    3 => Documents for visa
                                    4 => Payment Screen (Optional)
                                    5 => Tickets and Visa');
            $table->longText('response');
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
        Schema::dropIfExists('queries_entities');
    }
}
