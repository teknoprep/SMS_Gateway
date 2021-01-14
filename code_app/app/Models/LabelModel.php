<?php

namespace App\Models;

use CodeIgniter\Model;

class LabelModel extends Model
{
    protected $table      = 'tbl_labels';
    protected $primaryKey = 'label_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['label_name', 'is_active'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = ['label_name' => 'required'];
    protected $validationMessages = ["All fields are required"];
    protected $skipValidation     = true;
}
