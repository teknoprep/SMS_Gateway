<?php

namespace App\Models;

use CodeIgniter\Model;

class NumberModel extends Model
{
    protected $table      = 'tbl_numbers';
    protected $primaryKey = 'number_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['number', 'is_active', 'label_id', 'carrier_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = ['number' => 'required'];
    protected $validationMessages = ["All fields are required"];
    protected $skipValidation     = true;
}
