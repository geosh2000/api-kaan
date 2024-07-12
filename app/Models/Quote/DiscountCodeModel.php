<?php

namespace App\Models\Quote;

use CodeIgniter\Model;

class DiscountCodeModel extends Model
{
    protected $table = 'discount_codes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'code', 
        'description', 
        'category', 
        'tw_start', 
        'tw_end', 
        'bw_start', 
        'bw_end', 
        'blackout_dates', 
        'discount', 
        'property', 
        'currency'
    ];
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';
}
