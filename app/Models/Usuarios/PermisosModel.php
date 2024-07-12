<?php

namespace App\Models\Usuarios;

use CodeIgniter\Model;

class PermisosModel extends Model
{
    protected $table = 'usuario_permisos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre']; // Lista de campos permitidos para asignación masiva

    // Definir la relación con la tabla Roles_Permisos
    public function rolesPermisos()
    {
        return $this->hasMany(RolesPermisosModel::class, 'permiso_id', 'id');
    }
}
