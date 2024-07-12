<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesPermisosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'rol_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'permiso_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('rol_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permiso_id', 'permisos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('roles_permisos');
    }

    public function down()
    {
        $this->forge->dropTable('roles_permisos');
    }
}
