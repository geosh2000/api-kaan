<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermisosSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nombre' => 'config_usuarios',
            ],
            [
                'nombre' => 'dash_logs',
            ],
        ];

        // Insertar datos en la tabla 'permisos'
        $this->db->table('permisos')->insertBatch($data);
    }
}
