<?php

namespace App\Models\Transpo;

use App\Models\BaseModel;

class TransportacionesModel extends BaseModel
{
    protected $DBGroup = 'production';
    protected $table = 'qwt_transportaciones';
    protected $primaryKey = ['folio', 'tipo'];
    protected $allowedFields = ['id', 'shuttle', 'hotel', 'tipo', 'folio', 'date', 'pax', 'guest', 'time', 'flight', 'airline', 'pick_up', 'status', 'precio', 'correo', 'phone','tickets','related'];

    public function getFilteredTransportaciones($inicio, $fin, $status, $hotel = null, $tipo = null, $guest = null, $correo = null, $folio = null)
    {
        $builder = $this->db->table('qwt_transportaciones');

        if (!empty($guest)) {
            $builder->like('guest', $guest);
        } elseif (!empty($folio)) {
            $builder->where('folio', $folio);
        } elseif (!empty($correo)) {
            $builder->like('correo', $correo);
        } else {

            $builder->where('date >=', $inicio);
            $builder->where('date <=', $fin);

            if (!empty($status)) {
                $builder->whereIn('status', $status);
            }

            if (!empty($hotel)) {
                $builder->whereIn('hotel', $hotel);
            }

            if (!empty($tipo)) {
                $builder->whereIn('tipo', $tipo);
            }

        }

        return $builder->get()->getResultArray();
    }
    
}
