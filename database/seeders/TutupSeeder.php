<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TutupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('t_tutup')->insert([
            'id' => Str::uuid(36),
            'id_kebun' => 1,
            'id_mutu' => Str::uuid(36),
            'tahun' => '2001/01/01',
            'status' => true,
            'created_at' => Carbon::now(),
        ]);
    }
}
