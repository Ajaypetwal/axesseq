<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class Rolesseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([   
            [
                'name' => 'Professional',
            
            ],
        [
            'name' => 'Recruiter',
        
        ],
        [
            'name' => 'Organization',
       
        ]
    ]);    
    }
}
