<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use App\Http\Requests\KategoriResourceRequest;
use App\Models\KategoriModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;
class KategoriResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];
        $page = (object) [
            'title' => 'Daftar Kategori Barang yang terdaftar dalam sistem'
        ];
        /**
         * Set active menu
         */
        $activeMenu = 'kategori';
        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    /**
     * take Kategori data in JSON format for datatables
     * @throws \Exception
     */
    public function list(Request $request): JsonResponse
    {
        $kategoris = KategoriModel::select(['kategori_id', 'kategori_kode', 'kategori_nama']);
        return DataTables::of($kategoris)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kategori) {
                $btn  = '<a href="'.url('/kategori/' . $kategori->kategori_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/kategori/' . $kategori->kategori_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/kategori/'.$kategori->kategori_id).'">'
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
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah Kategori baru'
        ];
        /**
         * Set active menu
         */
        $activeMenu = 'kategori';
        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(KategoriResourceRequest $request): RedirectResponse
    {
        /**
         * Retrieve a portion of the validated input data...
         */
        $validated = $request->safe()->only(['kategori_kode', 'kategori_nama']);
        /**
         * Created row m_kategori Table data, base request form data
         */
        KategoriModel::create([
            'kategori_kode' => $validated['kategori_kode'],
            'kategori_nama' => $validated['kategori_nama'],
        ]);
        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $kategori = KategoriModel::find($id);
        $breadcrumb = (object)[
            'title' => 'Detail Kategori',
            'list' => ['Home', 'Kategori', 'Detail']
        ];
        $page = (object)[
            'title' => 'Detail Kategori'
        ];
        /**
         * Set active menu
         */
        $activeMenu = 'kategori';
        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'kategori' => $kategori, 'page' => $page,'activeMenu' => $activeMenu]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        /**
         * Retrieve specific kategori data
         */
        $kategori = KategoriModel::find($id);
        $breadcrumb = (object)[
            'title' => 'Edit Kategori',
            'list' => ['Home', 'Kategori', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Kategori'
        ];
        /**
         * Set active menu
         */
        $activeMenu = 'kategori';
        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(KategoriResourceRequest $request, string $id): RedirectResponse
    {
        /**
         * Retrieve a portion of the validated input data...
         */
        $validated = $request->safe()->only(['kategori_kode', 'kategori_nama']);
        /**
         * updated m_kategori tabel base of value validated request form data
         */
        KategoriModel::find($id)->update([
            'kategori_kode' => $validated['kategori_kode'],
            'kategori_nama' => $validated['kategori_nama'],
        ]);
        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $check = KategoriModel::find($id);
        /**
         * check whatever Kategori data with id is available or not
         */
        if (!$check) {
            return redirect('/kategori')->with('error', 'Data Kategori tidak ditemukan');
        }
        try {
            /**
             * Delete kategori data
             */
            KategoriModel::destroy($id);
            return redirect('/kategori')->with('success', 'Data Kategori berhasil dihapus');
        } catch (QueryException) {
            return redirect('/kategori')->with('error', 'Data Kategori gagal dihapus, karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}