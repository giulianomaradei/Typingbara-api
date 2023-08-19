<?php

namespace App\Repositories\Base;
use App\Repositories\Base\Interfaces\BaseInterface;

abstract class BaseRepository implements BaseInterface
{
    protected $model;

    public function parseResult($data, $message = 'OK', $status = 1)
    {
        $results = [
            'status' => null,
            'message' => $message,
            'data' => $data
        ];
        return response()->json($results);
    }
    public function newInstance()
    {
        return $this->model->newInstance();
    }
}
