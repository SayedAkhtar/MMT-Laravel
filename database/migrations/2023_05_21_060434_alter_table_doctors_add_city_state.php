<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDoctorsAddCityState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->foreignId('state_id')->nullable()->default(null)->constrained()->nullOnDelete();
            $table->foreignId('city_id')->nullable()->default(null)->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign('state_id');
            $table->dropForeign('city_id');
            $table->dropColumn('state_id');
            $table->dropColumn('city_id');
        });
    }
}
