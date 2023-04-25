<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //DB::table('agama')->truncate();
		$json = File::get('database/data/agama.json');
		$data = json_decode($json);
        foreach($data as $obj){
			DB::table('agamas')->insert([
				'id' 			=> $obj->id,
				'nama' 			=> $obj->nama,
				'created_at'	=> $obj->created_at,
				'updated_at' 	=> $obj->updated_at,
				'deleted_at'	=> $obj->deleted_at,
			]);
    	}
    }
}
