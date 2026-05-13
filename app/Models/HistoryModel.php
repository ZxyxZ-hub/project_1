<?php

namespace App\Models;

use CodeIgniter\Model;

class HistoryModel extends Model
{
    protected $table = 'history';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'item_table',
        'item_id',
        'action',
        'actor',
        'actor_full_name',
        'action_at',
        'from_name',
        'subject',
        'date_received',
        'details',
    ];
}
