<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterActiveQueriesAddPaymentId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('active_queries', function (Blueprint $table) {
            $table->foreignId('payment_id')->after('is_payment_done')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('active_queries', function (Blueprint $table) {
            $table->dropColumn(['payment_id']);
        });
    }
}
