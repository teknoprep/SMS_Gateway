<?php

namespace App\Models;

use CodeIgniter\Model;

class CarrierModel extends Model
{
    protected $table      = 'tbl_carriers';
    protected $primaryKey = 'carrier_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'function', 'is_active', 'label_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = ['name' => 'required'];
    protected $validationMessages = ["All fields are required"];
    protected $skipValidation     = true;
}
