<?php

namespace App\Models;

use CodeIgniter\Model;

class LlamadasModel extends Model
{
    protected $table = 'llamadas';
    protected $primaryKey = 'uniqueid';
    protected $allowedFields = ['Fecha', 'Hora', 'Queue', 'Agent', 'Number', 'Event', 'WaitTime', 'TalkTime', 'uniqueid'];
    protected $useAutoIncrement = false;
    protected $useTimestamps = false;
}
