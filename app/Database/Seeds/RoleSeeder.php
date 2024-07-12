<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $sm = model('App\Models\Usuarios\RoleModel');

        // Array de roles
        $roles = [
            [
                'nombre' => 'Super Administrador',
            ],
            [
                'nombre' => 'Administrador',
            ],
            [
                'nombre' => 'Usuario',
            ],
        ];

        // Using Query Builder
        $sm->insertBatch($roles);
        
    }
}
