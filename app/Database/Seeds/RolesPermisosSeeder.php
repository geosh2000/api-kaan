<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesPermisosSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'rol_id' => 1,
                'permiso_id' => 1, // ID del permiso config_usuarios
            ],
            [
                'rol_id' => 1,
                'permiso_id' => 2, // ID del permiso dash_logs
            ],
        ];

        // Insertar datos en la tabla 'roles_permisos'
        $this->db->table('roles_permisos')->insertBatch($data);
    }
}
