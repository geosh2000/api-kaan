<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $us = model('App\Models\Usuarios\UserModel');

        // Array de usuarios
        $usuarios = [
            [
                'username' => 'superadmin',
                'role_id' => 1,
                'nombre' => 'Super',
                'apellido' => 'Administrador',
                'email' => 'superadmin@geoshglobal.com',
                'password' => password_hash('@Dyj21278370', PASSWORD_DEFAULT),
            ],
            [
                'username' => 'admin',
                'role_id' => 2,
                'nombre' => 'Administrador',
                'apellido' => 'Administrador',
                'email' => 'admin@geoshglobal.com',
                'password' => password_hash('@AdminGg2023', PASSWORD_DEFAULT),
            ],
            [
                'username' => 'user',
                'role_id' => 3,
                'nombre' => 'Usuario',
                'apellido' => 'Usuario',
                'email' => 'user@geoshglobal.com',
                'password' => password_hash('12345', PASSWORD_DEFAULT),
            ],

        ];

        // Using Query Builder
        $us->insertBatch($usuarios);


    }
}
