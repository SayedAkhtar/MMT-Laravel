<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsersAddFirebaseTokenLocalAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firebase_token')
                ->nullable()
                ->default(null);
            $table->string('firebase_user')
                ->nullable()
                ->default(null);
            $table->text('local_auth')
                ->nullable()
                ->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('firebase_token');
            $table->dropColumn('firebase_user');
            $table->dropColumn('local_auth');
        });
    }
}
