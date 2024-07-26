<?php

namespace App\Models\Crs;

use App\Models\BaseModel;
use App\Exceptions\DbConnectionException;
use CodeIgniter\Database\Exceptions\DatabaseException;

class CrsModel extends BaseModel
{
    protected $DBGroup = 'adh_crs';
    protected $table = '[dbo].[Reservations]';
    protected $primaryKey = 'ReservationId';
    protected $allowedFields = ['DateFrom', 'DateTo','Adults', 'Children', 'Teens', 'Infants', 'Name', 'LastName', 'Email', 'AgencyNumber', 'ReservationId', 'HotelId', 'AgencyId'];

    public function getRsva( $folio, $from = '2023-01-01' ){

        $builder = $this->db->table('Reservations rsv');

        // Construye el query
        $builder->select("CASE WHEN htl.Name LIKE '%atelier playa mujeres%' THEN 'ATELIER' 
                            WHEN htl.Name LIKE '%Óleo Cancún Playa%' THEN 'OLEO' 
                            ELSE htl.Name END as Hotel");
        $builder->select('ReservationNumber');
        $builder->select('ReservationNumber as rsvPms');
        $builder->select('ReservationId as rsvCrs');
        $builder->select('DateFrom');
        $builder->select('DateTo');
        $builder->select('DATEDIFF(day, DateFrom, DateTo) as nights');
        $builder->select("CONCAT(rsv.Adults, '.', COALESCE(rsv.Children, 0) + COALESCE(rsv.Teens, 0) + COALESCE(rsv.Infants, 0)) as pax");
        $builder->select("CONCAT(rsv.Name, ' ', rsv.LastName) as Guest");
        $builder->select('rsv.Email as Email');
        $builder->select("COALESCE(AgencyNumber, CAST(ReservationId AS NVARCHAR)) as ReservationId");
        $builder->select("COALESCE(AgencyNumber, CAST(ReservationId AS NVARCHAR)) as rsvAgencia");
        $builder->select("agn.Name as Agencia");
        $builder->select("Company as Canal");
        $builder->select("CASE 
                            WHEN Company IN ('Website', 'contactcenter') 
                                AND (Notes LIKE '%Airport Transfer%' OR Notes LIKE '%Traslados Aeropuerto%') 
                            THEN 1 
                            ELSE 0 
                        END as isIncluida");

        // Join con la tabla Hotels
        $builder->join('Hotels htl', 'rsv.HotelId = htl.HotelId', 'left');
        // Join con la tabla Agencies
        $builder->join('Agencies agn', 'rsv.AgencyId = agn.AgencyId', 'left');

        // Agrega las condiciones del WHERE
        $f = $this->db->escapeString($folio);
        $builder->where("DateFrom >= '$from'");
        $builder->where("(CAST(ReservationId AS NVARCHAR) = '$f' 
                        OR CAST(ReservationNumber AS NVARCHAR) = '$f' 
                        OR AgencyNumber = '$f'
                        OR rsv.LastName LIKE '%$f%'
                        OR CONCAT(rsv.Name, ' ', rsv.LastName) LIKE '%$f%'
                        OR rsv.Name LIKE '%$f%')");

        try {
            // Ejecuta el query y obtiene los resultados
            $query = $builder->get();
            return $query->getResultArray();
        } catch (DatabaseException $e) {
            throw DbConnectionException::forDatabaseConnection();
        }

    }
    
    
    
}
