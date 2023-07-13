<?php

namespace Database\Seeders;

use App\Models\Specialization;
use App\Models\Treatment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return  void
     */
    public function run()
    {
        // $this->call(PermissionSeeder::class);
        // $this->call(RoleSeeder::class);
        // $this->call(DefaultUserSeeder::class);
        // $this->call(AssignPermissionsToRoleSeeder::class);
        // $this->seedTreatments();
        $this->call(DoctorSeederFromCSV::class);
    }

    public function seedTreatments()
    {
        $d = [];
        if (($open = fopen(__DIR__ . '/treatment.csv', "r")) !== FALSE) {

            while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
                $d[] = $data;
            }

            fclose($open);
        }
        DB::beginTransaction();
        DB::table('treatments')->truncate();
        foreach($d as $t){
            if(!empty($t[1]) && !empty($t[2]) && !empty($t[3]) && !empty($t[4])){
                $price = explode('-', $t[1]);
                $temp['name']  = $t[0];
                $temp['min_price']  = (int)filter_var($price[0], FILTER_SANITIZE_NUMBER_INT);
                $temp['max_price']  = isset($price[1])?(int)filter_var($price[1], FILTER_SANITIZE_NUMBER_INT): 0;
                $temp['logo'] = "public/".Str::slug($t[0]).".png";
                $temp['days_required'] = $t[2];
                $temp['recovery_time'] = $t[3];
                $temp['success_rate'] = $t[4];
                $temp['covered'] = $t[6];
                try{
                    $treatment = Treatment::create($temp);
                    $specialization = Specialization::where('name', 'like', '%'.$t[5].'%')->first()->id;
                    $treatment->specializations()->attach($specialization);
                    DB::commit();
                }catch (\Exception $e){
                    DB::rollBack();
                    dump($e->getMessage(), $t[5]);
                }
            }
        }
    }
}
