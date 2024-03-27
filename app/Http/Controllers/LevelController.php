<?php

namespace App\Http\Controllers;

use App\DataTables\LevelDataTable;
use App\Http\Requests\LevelRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index(LevelDataTable $dataTable)
    {
        return $dataTable->render('level.index');
    }
    public function create(): View
    {
        return view('level.create');
    }
    public function store(LevelRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $validated = $request->safe()->only(['level_kode', 'level_nama']);

        return redirect('/level');
    }
}
