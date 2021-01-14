<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageResponseModel extends Model
{
    protected $table      = 'sms_responses';
    protected $primaryKey = 'sr_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['response', 'is_active'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = ['number' => 'required'];
    protected $validationMessages = ["All fields are required"];
    protected $skipValidation     = true;
}
