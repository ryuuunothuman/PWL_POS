<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use App\Http\Requests\LevelResourceRequest;
use Illuminate\Http\RedirectResponse;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LevelModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LevelResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar Level User yang terdaftar dalam sistem'
        ];

        /**
         * retrieve all level_nama and level_id for filtering what level_kode that level_nama had feature
         */
        $levels = LevelModel::select(['level_id','level_nama'])->get();

        /**
         * Set active menu
         */
        $activeMenu = 'level';

        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'levels' => $levels,'activeMenu' => $activeMenu]);
    }

    /**
     * take level data in JSON format for datatables
     * @throws \Exception
     */
    public function list(Request $request): JsonResponse
    {
        $levels = LevelModel::select(['level_id', 'level_kode', 'level_nama']);

        /**
         * Filter User data that we retrieve above base level_id retrieved in user.index view
         */
        if ($request->level_id) {
            $levels->where('level_id', $request->level_id);
        }

        return DataTables::of($levels)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $btn  = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/level/'.$level->level_id).'">'

                    . csrf_field()
                    . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button>
                        </form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Level baru'
        ];

        /**
         * Set active menu
         */
        $activeMenu = 'level';

        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LevelResourceRequest $request): RedirectResponse
    {
        /**
         * Retrieve a portion of the validated input data...
         */
        $validated = $request->safe()->only(['level_kode', 'level_nama']);

        /**
         * Created row m_level Table data base request form data
         */
        LevelModel::create([
            'level_kode' => $validated['level_kode'],
            'level_nama' => $validated['level_nama'],
        ]);

        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Level'
        ];

        /**
         * Set active menu
         */
        $activeMenu = 'level';

        return view('level.show', ['breadcrumb' => $breadcrumb, 'level' => $level, 'page' => $page,'activeMenu' => $activeMenu]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        /**
         * Retrieve specific level data
         */
        $level = LevelModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Level'
        ];

        /**
         * Set active menu
         */
        $activeMenu = 'level';

        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LevelResourceRequest $request, string $id): RedirectResponse
    {
        /**
         * Retrieve a portion of the validated input data...
         */
        $validated = $request->safe()->only(['level_kode', 'level_nama']);

        /**
         * updated m_level tabel base of value request form data
         */
        LevelModel::find($id)->update([
            'level_kode' => $validated['level_kode'],
            'level_nama' => $validated['level_nama'],
        ]);


        return redirect('/level')->with('success', 'Data level berhasil diubah');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $check = LevelModel::find($id);

        /**
         * check whatever user data with id is available or not
         */
        if (!$check) {
            return redirect('/level')->with('error', 'Data Level tidak ditemukan');
        }

        try {
            /**
             * Delete level data
             */
            LevelModel::destroy($id);
            return redirect('/level')->with('success', 'Data Level berhasil dihapus');
        } catch (QueryException) {
            return redirect('/level')->with('error', 'Data Level gagal dihapus, karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}