<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JenisPenerimaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_jenis_penerimaan')->insert([
            'id' => Str::uuid(36),
            'nama' => 'Blending',
            'status' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
