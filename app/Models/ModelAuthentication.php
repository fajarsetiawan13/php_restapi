<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ModelAuthentication extends Model
{
    protected $table = "authentication";
    protected $primaryKey = "id";
    protected $allowedFields = ["email", "password"];


    function getEmail($email)
    {
        $builder = $this->table("authentication");
        $data = $builder->where("email", $email)->first();

        if (!$data) {
            throw new Exception("Data not found!");
        }

        return $data;
    }
}
