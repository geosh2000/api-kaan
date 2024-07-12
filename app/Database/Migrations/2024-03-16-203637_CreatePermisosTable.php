<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermisosTable extends Migration
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
            'nombre' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            // Agrega otros campos según tus necesidades
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('permisos');
    }

    public function down()
    {
        $this->forge->dropTable('usuario_permisos');
    }
}
