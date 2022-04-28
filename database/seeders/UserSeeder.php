<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $data = [
            [
                'qr_ref' => 'AA1234',
                'username' => 'admin',
                'lname' => 'LOPEZ',
                'fname' => 'ANGEL',
                'mname' => 'P',
                'sex' => 'FEMALE',
                'province' => '1042',
                'city' => '104215',
                'barangay' => '104215027',
                'street' => 'P-6',
                'email' => 'angel@dev.com',
                'contact_no' => '09167789585',
                'role' => 'ADMINISTRATOR',
                'password' => Hash::make('a')
            ],
            [
                'qr_ref' => 'BB1234',
                'username' => 'jov',
                'lname' => 'MAGLANGIT',
                'fname' => 'JOV',
                'mname' => '',
                'sex' => 'MALE',
                'province' => '1042',
                'city' => '104215',
                'barangay' => '104215027',
                'street' => 'P-SAMPLE',
                'email' => 'riche@dev.com',
                'contact_no' => '09167789584',
                'role' => 'ADMINISTRATOR',
                'password' => Hash::make('a')
            ],
            
        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
