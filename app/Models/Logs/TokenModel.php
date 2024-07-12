<?php

namespace App\Models\Logs;

use CodeIgniter\Model;

class TokenModel extends Model
{
    protected $table = 'tokens';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'token', 'expiration_date', 'created_at', 'updated_at'];
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function user()
    {
        return $this->belongsTo('App\Models\Usuarios\UserModel', 'user_id');
    }
}
