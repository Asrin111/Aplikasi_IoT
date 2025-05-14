<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeviceSeeder extends Seeder
{
    public function run()
    {
        DB::table('devices')->insert([
            [
                'device_id' => 'SmartAgriculture',
                'tipe' => 'Plants',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'device_id' => 'SmartCity',
                'tipe' => 'Parking',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'device_id' => 'SmartCity',
                'tipe' => 'DoorLock',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}