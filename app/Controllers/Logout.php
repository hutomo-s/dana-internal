<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Logout extends BaseController
{
    public function index()
    {
        $session = service('session');
        $session->destroy();
        return redirect()->to(base_url('dashboard/login'));
    }
}