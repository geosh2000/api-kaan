<?php

namespace App\Models\Transpo;

use App\Models\BaseModel;

class TransportacionesModel extends BaseModel
{
    protected $DBGroup = 'production';
    protected $table = 'qwt_transportaciones';
    protected $primaryKey = ['folio', 'item', 'tipo'];
    protected $allowedFields = ['id', 'shuttle', 'isIncluida', 'hotel', 'tipo', 'folio', 'item', 'date', 'pax', 'guest', 'time', 'flight', 'airline', 'pick_up', 'status', 'precio', 'correo', 'phone','tickets','related', 'ticket_payment', 'ticket_pago', 'ticket_sent_request', 'crs_id', 'pms_id', 'agency_id'];

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

    public function searchComplete( $searchTerm ){

        $builder = $this->db->table($this->table . ' st')
                            ->select('
                                st.shuttle,
                                st.hotel,
                                st.folio,
                                st.item,
                                st.crs_id,
                                st.pms_id,
                                st.agency_id,
                                st.guest,
                                st.pax,
                                st.correo,
                                st.phone,
                                st.isIncluida,
                                st.id as id_in,
                                st.date as date_in,
                                st.flight as flight_in,
                                st.airline as airline_in,
                                st.time as time_in,
                                st.status as status_in,
                                st.precio as precio_in,
                                st.tickets as tickets_in,
                                st.ticket_payment as ticket_payment_in,
                                st.ticket_pago as ticket_pago_in,
                                st.ticket_sent_request as ticket_sent_request_in,
                                nd.id as id_out,
                                nd.date as date_out,
                                nd.flight as flight_out,
                                nd.airline as airline_out,
                                nd.time as time_out,
                                nd.status as status_out,
                                nd.precio as precio_out,
                                nd.tickets as tickets_out,
                                nd.ticket_payment as ticket_payment_out,
                                nd.ticket_pago as ticket_pago_out,
                                nd.ticket_sent_request as ticket_sent_request_out,
                                IF(st.status = nd.status, st.status,null) as globalStatus
                            ')
                            ->join('cycoasis_adh.qwt_transportaciones nd', 'st.folio = nd.folio AND st.item = nd.item AND st.tipo = "ENTRADA" AND nd.tipo = "SALIDA"', 'left')
                            ->where('(nd.folio = "'.$searchTerm.'" OR COALESCE(nd.crs_id,"x") = "'.$searchTerm.'" OR COALESCE(nd.pms_id,"x") = "'.$searchTerm.'" OR COALESCE(nd.agency_id,"x") = "'.$searchTerm.'" OR COALESCE(nd.guest,"x") LIKE "%'.$searchTerm.'%")');

        return $builder->get()->getResultArray();

    }

    public function searchAll( $id ){

        $builder = $this->db->table('qwt_transportaciones');

        $builder->where('folio', $id)
                ->orWhere('crs_id',$id)
                ->orWhere('pms_id',$id)
                ->orWhere('agency_id',$id)
                ->orLike('guest',$id)
                ->orderBy('tipo, item');

        return $builder->get()->getResultArray();

    }

    public function getByFolio( $id ){
        $builder = $this->db->table('qwt_transportaciones');

        $builder->where('folio', $id)->orderBy('tipo, item');

        return $builder->get()->getResultArray();
    }

    public function updateById($id, $data){
        $builder = $this->db->table('qwt_transportaciones');

        $builder->where('id', $id)->set($data);

        return $builder->update();
    }

    
    
}
