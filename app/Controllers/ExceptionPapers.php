<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class ExceptionPapers extends BaseController
{

    public function index()
    {
        $data = [];

        return view('dashboard/ep_index', $data);
    }

    public function create()
    {
        helper('exception_paper');

        $authorize_ep_create = authorize_ep_create();

        $date = Time::now()->toDateString();;

        $data = [
            'warning_message' => $authorize_ep_create->message,
            'is_eligible_submit' => $authorize_ep_create->is_eligible,
            'api_ep_store' => base_url('api/exception-papers/store'),
            'date' => $date,
        ];

        return view('dashboard/ep_create', $data);
    }
}
