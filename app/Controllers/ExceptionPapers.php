<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ExceptionPapers extends BaseController
{

    public function index()
    {
        $data = [];

        return view('dashboard/ep_index', $data);
    }

}
