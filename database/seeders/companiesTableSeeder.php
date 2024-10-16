<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\company;
use Database\Factories\companiesFactory;
use DateTime;

class companiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            [
                'id' => 1,
                'company_name' => 'santary',
                'street_address' => '中央区桜丘1-2',
                'representative_name' => '近森',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'id' => 2,
                'company_name' => 'koka-kora',
                'street_address' => '緑区上峰3-4',
                'representative_name' => '佐藤',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            ],
            [
                'id' => 3,
                'company_name' => 'Bsahi',
                'street_address' =>'中央区八王子5-6',
                'representative_name' => '小林',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime()
            
            ]
        ]);
    }
}
