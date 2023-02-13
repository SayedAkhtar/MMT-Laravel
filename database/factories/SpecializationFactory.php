<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SpecializationFactory extends Factory
{
    protected $specializations =  [
        "Adult Intensivist",
        "Allergy",
        "Anesthesia",
        "Bariatric Medicine/Surgery",
        "Burn/Trauma",
        "Cardiac Catheterization",
        "Cardiology",
        "Cardiovascular Surgery",
        "Colorectal Surgery",
        "Dermatology",
        "Electrophysiology",
        "Emergency Medicine",
        "Endocrinology",
        "Family Practice",
        "Gastroenterology",
        "General Surgery",
        "Geriatrics",
        "Gynecologic Oncology",
        "Hematology/Oncology",
        "Hepatobiliary",
        "Hospitalist",
        "Infectious Disease",
        "Internal Medicine",
        "Interventional Radiology",
        "Medical Genetics",
        "Neonatology",
        "Nephrology",
        "Neuroradiology",
        "Neurology",
        "Neurosurgery",
        "Nuclear Medicine",
        "Obstetrics & Gynecology",
        "Occupational Medicine",
        "Ophthalmology",
        "Oral Surgery",
        "Orthopedics",
        "Otolaryngology / Head & Neck Surgery",
        "Pain Management",
        "Palliative Care",
        "Pain Management",
        "Palliative Care",
        "Pathology: Surgical & Anatomic",
        "Pediatric Intensivist",
        "Pediatrics",
        "Pediatric Surgery",
        "Physical Medicine"
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->randomElement($this->specializations),
            'logo' => $this->faker->imageUrl
        ];
    }
}