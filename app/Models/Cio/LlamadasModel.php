<?php

namespace App\Models\Cio;

use CodeIgniter\Model;

class LlamadasModel extends Model
{
    protected $table = 'llamadas_cio';
    protected $primaryKey = 'global_id';

    protected $allowedFields = [
        'global_id',
        'fecha',
        'hora',
        'cola',
        'hotel',
        'idioma',
        'tipo_llamada',
        'ivr',
        'tiempo_cola',
        'tiempo_en_espera',
        'en_espera',
        'dentro_del_tiempo_de_espera',
        'escenario',
        'duracion_hablada',
        'duracion_en_espera',
        'duracion_total',
        'desde',
        'transferido_desde',
        'destino_original',
        'conectado_a',
        'servicio_campana',
        'disposicion_agente',
        'disposicion',
        'notas',
        'marcado_timbrando'
    ];

    protected $useTimestamps = false;

    protected $dateFormat = 'datetime'; // Establece un formato de fecha válido, por ejemplo, 'yyyy-MM-dd'

    protected $returnType = 'array';
}
