<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qualifications', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('degisnations', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('role')->references('id')->on('roles')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }
}
