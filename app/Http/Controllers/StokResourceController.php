<?php

namespace App\Http\Controllers;

use App\Http\Requests\StokResourceRequest;
use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class StokResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $page = (object) [
            'title' => 'Daftar Stok yang terdaftar dalam sistem'
        ];

        /**
         * Set active menu
         */
        $activeMenu = 'stok';

        /**
         * Retrieve all barang data for filter in stok table, columns are dependable filter requirement
         */
        $barangs = BarangModel::select(['barang_id', 'barang_nama'])->get();

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barangs' => $barangs, 'activeMenu' => $activeMenu]);
    }

    /**
     * take stok data in JSON format for datatables
     * @throws \Exception
     */
    public function list(Request $request): JsonResponse
    {
        $stoks = StokModel::with('barang', 'user');

        /**
         * Filter Barang data that we retrieve above base kategori_id retrieved in barang.index view
         */
        if ($request->barang_id) {
            $stoks->where('barang_id', $request->barang_id);
        }

        /**
         * Option for not filtered or use all stok data
         */
        $stoks = $stoks->get();

        return DataTables::of($stoks)
            ->addIndexColumn()
            ->addColumn('aksi', function ($stok) {
                $btn  = '<a href="'.url('/stok/' . $stok->stok_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/stok/' . $stok->stok_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/stok/'.$stok->stok_id).'">'

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
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Stok baru'
        ];

        /**
         * Retrieve all column user_id data and nama from m_user for create foreign key in form
         */
        $users = UserModel::select(['user_id', 'nama'])->get();

        /**
         * Retrieve all column barang_id data and barang_nama from m_barang for create foreign key in form
         */
        $barangs = BarangModel::select(['barang_id', 'barang_nama'])->get();

        /**
         * Set active menu
         */
        $activeMenu = 'stok';

        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'users' => $users, 'barangs' => $barangs, 'activeMenu' => $activeMenu]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StokResourceRequest $request): RedirectResponse
    {
        /**
         * Retrieve a portion of the validated input data...
         */
        $validated = $request->safe()->except('stok_id');

        /**
         * Created row m_stok Table data, base request form data
         */
        StokModel::insert($validated);

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $stok = StokModel::with('barang', 'user')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Barang'
        ];

        /**
         * Set active menu
         */
        $activeMenu = 'stok';

        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok,'activeMenu' => $activeMenu]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        /**
         * Retrieve specific stok data with id
         */
        $stok = StokModel::find($id);

        /**
         * Retrieve all user_id and nama for make user easy to edit t_stok tabel
         */
        $users = UserModel::select(['user_id', 'nama'])->get();

        /**
         * Retrieve all barang_id and barang_nama for make user easy to edit t_stok tabel
         */
        $barangs = BarangModel::select(['barang_id', 'barang_nama'])->get();

        $breadcrumb = (object)[
            'title' => 'Edit Stok',
            'list' => ['Home', 'Stok', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Stok'
        ];

        /**
         * Set active menu
         */
        $activeMenu = 'stok';

        return view('stok.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'users' => $users, 'barangs' => $barangs, 'activeMenu' => $activeMenu]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StokResourceRequest $request, string $id): RedirectResponse
    {
        /**
         * Retrieve a portion of the validated input data...
         */
        $validated = $request->safe()->except('stok_id');

        /**
         * Update row t_stok Table data, base request form data
         */
        StokModel::where('stok_id', $id)->update($validated);

        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $check = StokModel::find($id);

        /**
         * check whatever stok data with id is available or not
         */
        if (!$check) {
            return redirect('/stok')->with('error', 'Data Stok tidak ditemukan');
        }

        try {
            /**
             * Delete stok data
             */
            StokModel::destroy($id);
            return redirect('/stok')->with('success', 'Data Stok berhasil dihapus');
        } catch (QueryException) {
            return redirect('/stok')->with('error', 'Data Stok gagal dihapus, karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}