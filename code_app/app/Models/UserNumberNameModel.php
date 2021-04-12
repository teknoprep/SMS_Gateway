<?php

namespace App\Models;

use CodeIgniter\Model;

class UserNumberNameModel extends Model
{
    protected $table      = 'tbl_user_number_info';
    protected $primaryKey = 'uni_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['user_id', 'number_id', 'is_active', 'alias'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = ['number_id' => 'required'];
    protected $validationMessages = ["All fields are required"];
    protected $skipValidation     = true;
}
