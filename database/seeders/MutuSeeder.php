<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MutuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_mutu')->insert([
            'id' => Str::uuid(36),
            'nomu' => 1,
            'kode' => 'BOP',
            'nama' => 'TEH ORTD',
            'status' => true,
            'created_at' => Carbon::now(),
        ]);
    }
}
