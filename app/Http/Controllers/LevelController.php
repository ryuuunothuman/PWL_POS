<?php

namespace App\Http\Controllers;

use App\DataTables\LevelDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index(LevelDataTable $dataTable)
    {
        return $dataTable->render('level.index');
    }
    public function create()
    {
        return view('level.create');
    }
}
