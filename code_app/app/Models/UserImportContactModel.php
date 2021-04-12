<?php

namespace App\Models;

use CodeIgniter\Model;

class UserImportContactModel extends Model
{
    protected $table      = 'tbl_user_import_contacts';
    protected $primaryKey = 'uni_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'mobile_number', 'business_number', 'home_number', 'user_id', 'is_active'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = ['number' => 'required'];
    protected $validationMessages = ["All fields are required"];
    protected $skipValidation     = true;
}
