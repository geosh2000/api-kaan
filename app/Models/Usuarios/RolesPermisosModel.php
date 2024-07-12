<?php

namespace App\Models\Usuarios;

use CodeIgniter\Model;

class RolesPermisosModel extends Model
{
    protected $table = 'roles_permisos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['rol_id', 'permiso_id']; // Lista de campos permitidos para asignación masiva

    // Definir la relación con la tabla Permisos
    public function permiso()
    {
        return $this->belongsTo(PermisosModel::class, 'permiso_id', 'id');
    }

    // Definir la relación con la tabla Roles
    public function rol()
    {
        return $this->belongsTo(RoleModel::class, 'rol_id', 'id');
    }

    public function obtenerPermisosPorUsuario($usuarioId)
    {
        // Obtener los permisos del usuario consultando la base de datos
        $builder = $this->db->table('users ur');
        $builder->select('p.nombre');
        $builder->join('roles_permisos rp', 'rp.rol_id = ur.role_id');
        $builder->join('permisos p', 'p.id = rp.permiso_id');
        $builder->where('ur.id', $usuarioId);
        $permisos = $builder->get()->getResultArray();

        if (empty($permisos)) {
            throw new \RuntimeException('El usuario no cuenta con un perfil asignado.');
        }

        // Extraer solo los nombres de los permisos
        $nombresPermisos = array_column($permisos, 'nombre');

        return $nombresPermisos;
    }
}
