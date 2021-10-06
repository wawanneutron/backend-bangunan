<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url_provinces = "https://api.rajaongkir.com/starter/province?key=93d5735fe06284aea65120e2548a5f3c";
        $json_str      = file_get_contents($url_provinces);
        $json_obj      = json_decode($json_str);

        $provinces     = [];
        foreach ($json_obj->rajaongkir->results as $province) {
            $provinces[] = [
                'province_id' => $province->province_id,
                'name'        => $province->province,
                'created_at'  => date(now())
            ];
        }
        DB::table('provinces')->insert($provinces);
    }
}
