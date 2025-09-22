<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name' 		=> 'Werneck de Oliveira',
        	'email' 	=> 'werneck.oliveira@infobase.com.br',
        	'password'  => bcrypt('123456'),
        	'cpf'		=> '09986185009',
            'telefone'  => '2135899874',
            'admin'     => true
        ]);
    }
}
