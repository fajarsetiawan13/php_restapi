<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelEmployees extends Model
{
    protected $table = "employees";
    protected $primaryKey = "id";
    protected $allowedFields = ["name", "email"];

    protected $validationRules = [
        "name" => "required",
        "email" => "required|valid_email"
    ];

    protected $validationMessages = [
        "name" => [
            "required" => "Name is required!"
        ],
        "email" => [
            "required" => "Email is required!",
            "valid_email" => "Email not valid!"
        ]
    ];
}
