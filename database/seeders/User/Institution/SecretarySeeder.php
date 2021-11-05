<?php

namespace Database\Seeders\User\Institution;

use Illuminate\Database\Seeder;
use App\Models\{
    Address, 
    Institution, 
    User
};

class SecretarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address = Address::create([
            'zipcode' => '11665-050',
            'street' => 'Avenida Rio de Janeiro',
            'number' => '860',
            'district' => 'Indaiá',
            'city' => 'Caraguatatuba',
            'state' => 'SP'
        ]);

        $institution = Institution::create([
            'name' => 'Secretaria de Educação de Caraguatatuba',
            'type' => 'SECRETARY',
            'address_id' => $address->id,
            'phone' => '(12) 3897-7000'
        ]);

        User::create([
            'name' => 'Tiago Villalobos',
            'username' => 'tiago',
            'password' => bcrypt('tiago'),
            'email' => 'tiagolimavillalobos@gmail.com',
            'phone' => '(12) 98190-4120',
            'institution_id' => $institution->id
        ]);
    }
}
