<?php
namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    public function insertIgnore(array $data)
    {
        if ($this->useTimestamps) {
            $date = $this->setDate();
            $data[$this->createdField] = $date;
            $data[$this->updatedField] = $date;
        }

        $builder = $this->builder();
        $builder->ignore(true);
        $builder->insert($data);

        return $this->db->affectedRows();
    }
}
