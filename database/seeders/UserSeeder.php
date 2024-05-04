<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /** 
     * Valores a serem inseridos na tabela
    */
    private array $fields = [
        [
            'name' => 'Gustavo Sachetto',
            'email' => 'gustavo@gmail.com',
            'password' => 'admin'
        ],
        [
            'name' => 'Gustavo Gualda',
            'email' => 'gualda@gmail.com',
            'password' => 'admin'
        ],
        [
            'name' => 'Lucas Firmino',
            'email' => 'firmino@email.com',
            'password' => 'admin'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->fields as $value) {
            DB::table('users')->insert($value);
        }
    }
}
