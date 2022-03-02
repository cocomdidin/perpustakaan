<?php

use App\Rak;
use Illuminate\Database\Seeder;

class RakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rak::insert([
            [
                'id' => 1,
                'nama' => '001'
            ],
            [
                'id' => 2,
                'nama' => '002'
            ],
            [
                'id' => 3,
                'nama' => '003'
            ]
        ]);
    }
}
