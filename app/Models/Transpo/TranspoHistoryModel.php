<?php

namespace App\Models\Transpo;

use App\Models\BaseModel;

class TranspoHistoryModel extends BaseModel
{
    protected $DBGroup = 'production';
    protected $table = 'qwt_history';
    protected $primaryKey = 'historyId';
    protected $allowedFields = ['id', 'title', 'comment', 'user'];

    public function create($id, $batch = false, $origin = "")
    {
        $data = [];

        if( !$batch ){
            $id = [$id];
        }
        
        foreach( $id as $idx => $d ){
            $tmp = [
                'id' => $d,
                'title' => "Nuevo Registro",
                'comment' => "Nuevo registro generado".($batch ? " por el sistema" : ""),
                'user' => $origin == "" ? $this->username() : $origin
            ];
            array_push($data, $tmp);
        }

        $builder = $this->db->table($this->table);
        $builder->insertBatch($data);
    }

    public function cancel($id, $batch = false)
    {
        $data = [];

        if( !$batch ){
            $id = [$id];
        }
        
        foreach( $id as $idx => $d ){
            $tmp = [
                'id' => $d,
                'title' => "Registro Cancelado",
                'comment' => "Registro Cancelado".$batch ? " por el sistema" : "",
                'user' => $this->username()
            ];
            array_push($data, $tmp);
        }

        $builder = $this->db->table($this->table);
        $builder->insertBatch($data);
    }
    
    public function edit($id, $arr)
    {
        $updateData = [];

        foreach( $arr as $i => $v ){
            $data = [
                'id' => $id,
                'title' => "Cambio ".$v[0],
                'comment' => $v[1]." => ".$v[2],
                'user' => $this->username()
            ];
            array_push($updateData, $data);
        }

        $builder = $this->db->table($this->table);
        $builder->insertBatch($updateData);
    }

    private function username(){
        $session = session();
        return $session->get('username');
    }

    private function insData( $data ){
        $builder = $this->db->table($this->table);
        $builder->insert($data);

        // return $builder->insertID();
    }

    public function getAll($id){
        $builder = $this->db->table($this->table);
        
        return $builder->where('id',$id)->orderBy('dtCreated')->get()->getResultArray();
    }
    
    
}
