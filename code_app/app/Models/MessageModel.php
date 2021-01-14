<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table      = 'tbl_sms_logs';
    protected $primaryKey = 'sl_id';

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['sender_id', 'receiver_id', 'user_id', 'message', 'status', 'is_active'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = ['number' => 'required'];
    protected $validationMessages = ["All fields are required"];
    protected $skipValidation     = true;
}
