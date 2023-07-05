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
        Schema::table('past_queries', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('set null')->onUpdate('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('query_id')->references('id')->on('queries')->onDelete('cascade');
        });


        Schema::table('patient_families', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('family_id')->references('id')->on('patient_family_details')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('queries', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('patient_family_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('specialization_id')->references('id')->on('specializations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('hospital_treatments', function (Blueprint $table) {
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('cascade');
            $table->foreign('treatment_id')->references('id')->on('treatments')->onDelete('cascade');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('accreditation_hospitals', function (Blueprint $table) {
            $table->foreign('accreditation_id')->references('id')->on('accreditations')->cascadeOnDelete();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->cascadeOnDelete();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('doctor_patient_testimonials', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null')->onUpdate('set null');
            $table->foreign('testimonial_id')->references('id')->on('patient_testimonies')->cascadeOnDelete();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('doctor_tags', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('doctors')->cascadeOnDelete();
            $table->foreign('tag_id')->references('id')->on('tags')->cascadeOnDelete();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('doctor_specializations', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('doctors')->cascadeOnDelete();
            $table->foreign('specialization_id')->references('id')->on('specializations')->cascadeOnDelete();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('doctor_hospitals', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('doctors')->cascadeOnDelete();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->cascadeOnDelete();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('patient_testimony_tags', function (Blueprint $table) {
            $table->foreign('testimony_id')->references('id')->on('patient_testimonies')->cascadeOnDelete();
            $table->foreign('tag_id')->references('id')->on('tags')->cascadeOnDelete();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('patient_testimonies', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('set null')->onUpdate('set null');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('detoxification_wellness', function (Blueprint $table) {
            $table->foreign('detoxification_category_id')->references('id')->on('detoxification_categories')->cascadeOnDelete();
            $table->foreign('wellness_center_id')->references('id')->on('wellness_centers')->cascadeOnDelete();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('detoxification_categories', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('wellness_centers', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('accommodation_facilities', function (Blueprint $table) {
            $table->foreign('accommodation_id')->references('id')->on('accommodations')->cascadeOnDelete();
            $table->foreign('facility_id')->references('id')->on('facilities')->cascadeOnDelete();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('facilities', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('accommodation_types', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('accommodations', function (Blueprint $table) {
            $table->foreign('type')->references('id')->on('accommodation_types')->onDelete('set null')->onUpdate('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('doctor_treatments', function (Blueprint $table) {
            $table->foreign('doctor_id')->references('id')->on('doctors')->cascadeOnDelete();
            $table->foreign('treatment_id')->references('id')->on('treatments')->cascadeOnDelete();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('specialization_treatments', function (Blueprint $table) {
            $table->foreign('specialization_id')->references('id')->on('specializations')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('treatment_id')->references('id')->on('treatments')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('tests', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('treatments', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('hospital_tags', function (Blueprint $table) {
            $table->foreign('hospital_id')->references('id')->on('hospitals')->cascadeOnDelete();
            $table->foreign('tag_id')->references('id')->on('tags')->cascadeOnDelete();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('tags', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('accreditations', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('specializations', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('designations', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('hospitals', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('patient_details', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('speciality')->references('id')->on('specializations')->onDelete('set null')->onUpdate('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('patient_family_details', function (Blueprint $table) {
            $table->foreign('patient_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('qualifications', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('qualification_id')->references('id')->on('qualifications')->onDelete('set null')->onUpdate('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('set null');
        });
    }
}
