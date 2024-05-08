<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Admin',
            'list' => ['Home', 'Admin']
        ];

        $page = (object)[
            'title' => 'Halo Admin'
        ];

        $activeMenu = 'admin';

        return view('admin', compact('breadcrumb', 'page', 'activeMenu'));
    }
}
