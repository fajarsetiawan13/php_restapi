<?php

namespace App\Controllers;

use App\Models\ModelEmployees;
use CodeIgniter\API\ResponseTrait;

class Employees extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $model = new ModelEmployees();

        $data = $model->orderBy("name", "asc")->findAll();

        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $model = new ModelEmployees();

        $data = $model->where("id", $id)->findAll();

        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data not found!");
        }
    }

    public function create()
    {
        $model = new ModelEmployees();

        $data = $this->request->getPost();

        if (!$model->save($data)) {
            return $this->fail($model->errors());
        }

        $response = [
            "status" => 201,
            "error" => null,
            "messages" => [
                "success" => "New Employees Successfully Added!"
            ]
        ];

        return $this->respond($response);
    }

    public function update($id = null)
    {
        $model = new ModelEmployees();

        $isExists = $model->where("id", $id)->findAll();

        if (!$isExists) {
            return $this->failNotFound("Data not found!");
        }

        $data = $this->request->getRawInput();
        $data["id"] = $id;

        if (!$model->save($data)) {
            return $this->fail($model->errors());
        }

        $response = [
            "status" => 200,
            "error" => null,
            "messages" => [
                "success" => "Employee's Successfully Updated!"
            ]
        ];

        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $model = new ModelEmployees();

        $isExists = $model->where("id", $id)->findAll();

        if ($isExists) {
            $model->delete($id); 

            $response = [
                "status" => 200,
                "error" => null,
                "messages" => "Employee Successfully Deleted!"
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound("Data not found!");
        }
    }
}
