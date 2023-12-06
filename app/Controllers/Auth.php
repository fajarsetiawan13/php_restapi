<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\ModelAuthentication;

class Auth extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $validation = \Config\Services::validation();

        $rules = [
            "email" => [
                "rules" => "required|valid_email",
                "errors" => [
                    "required" => "Email is required!",
                    "valid_email" => "Email not valid!"
                ]
            ],
            "password" => [
                "rules" => "required",
                "errors" => [
                    "required" => "Password is required!",
                ]
            ]
        ];

        $validation->setRules($rules);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->fail($validation->getErrors());
        }

        $model = new ModelAuthentication();

        $email = $this->request->getVar("email");
        $password = $this->request->getVar("password");

        $data = $model->getEmail($email);

        if ($data["password"] != $password) {
            return $this->fail("Password incorrect!");
        }

        helper("jwt");
        $response = [
            "status" => 200,
            "error" => null,
            "messages" => "Authentication Success",
            "access_token" => createJWT($email),
            "data" => $data
        ];

        return $this->respond($response);
    }
}
