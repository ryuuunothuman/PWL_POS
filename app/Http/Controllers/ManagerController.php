<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Manager',
            'list' => ['Home', 'Manager']
        ];

        $page = (object)[
            'title' => 'Halo Manager'
        ];

        $activeMenu = 'manager';

        return view('manager', compact('breadcrumb', 'page', 'activeMenu'));
    }
}
