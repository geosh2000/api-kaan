<?php

namespace App\Models\Warehouse;

use CodeIgniter\Model;

class RoomTypesModel extends Model
{
    protected $DBGroup = 'adh_wh'; // Grupo de base de datos
    protected $table = 'RemoteAtelierFrontCRS_RoomTypes';
    protected $primaryKey = 'RoomTypeId';

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'HotelId',
        'RoomTypeId',
        'Name',
        'Code',
        'MaxPersons',
        'MaxExtra',
        'GroupRoomTypeId',
        'IsInspira',
        'OrderPriority',
        'Adults',
        'Kids',
        'Activo'
    ];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}
