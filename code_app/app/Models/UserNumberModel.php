<?php

namespace App\Models;

use CodeIgniter\Model;

class UserNumberModel extends Model
{
    protected $table      = 'tbl_user_numbers';
    protected $primaryKey = 'un_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['user_id', 'number_id', 'is_active'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = ['number' => 'required'];
    protected $validationMessages = ["All fields are required"];
    protected $skipValidation     = true;
}
