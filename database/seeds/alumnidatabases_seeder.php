<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class alumnidatabases_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for($i = 1; $i <= 7; $i++){
 
            // insert data ke table pegawai menggunakan Faker
          DB::table('alumnidatabases')->insert([
              'nama' => $faker->name,
              'id_periode' => $faker->numberBetween(1,2),
              'tingkat_kompetensi' => $faker->shuffle('ABC'),
              'tanggal_terbit' => $faker->date('Y-m-d'),
              'tanggal_pengambilan' => $faker->date('Y-m-d'),
              'keterangan' => $faker->shuffle('ABC')
          ]);

      }
    }
    
}
