<?php

namespace App\Models;
use CodeIgniter\Model;

class FormModel extends Model
{
    protected $table = 'forms';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'from_name',
        'date_received',
        'origin',
        'reference_no',
        'subject',
        'instructions'
    ];
}