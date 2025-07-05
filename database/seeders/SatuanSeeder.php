<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_satuan')->insert([
            'id' => Str::uuid(36),
            'tenant_id' => Str::uuid(36),
            'nama' => 'KG',
            'status' => 1,
            'created_at' => Carbon::now(),
        ]);
    }
}
