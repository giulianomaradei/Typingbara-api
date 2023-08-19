<?php

namespace App\Repositories\Base\Interfaces;

interface BaseInterface
{
    public function parseResult($data, $message = 'OK', $status = 1);
    public function newInstance();
}
