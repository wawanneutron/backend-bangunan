<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $url_cities = "https://api.rajaongkir.com/starter/city?key=93d5735fe06284aea65120e2548a5f3c";
        $json_str      = file_get_contents($url_cities);
        $json_obj      = json_decode($json_str);

        $cities     = [];
        foreach ($json_obj->rajaongkir->results as $city) {
            $cities[] = [
                'province_id' => $city->province_id,
                'city_id'     => $city->city_id,
                'name'        => $city->city_name,
                'created_at'  => date(now())
            ];
        }
        DB::table('cities')->insert($cities);
    }
}
