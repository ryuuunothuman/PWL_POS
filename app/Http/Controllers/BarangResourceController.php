<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangResourceRequest;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class BarangResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $breadcrumb = (object) [
            'title' => 'Daftar barang',
            'list' => ['Home', 'barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        /**
         * Set active menu
         */
        $activeMenu = 'barang';

        /**
         * Retrieve all kategori data for filter in barang table, columns are dependable filter requirement
         */
        $kategoris = KategoriModel::select(['kategori_id', 'kategori_nama'])->get();

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategoris' => $kategoris,'activeMenu' => $activeMenu]);
    }

    /**
     * take barang data in JSON format for datatables
     * @throws \Exception
     */
    public function list(Request $request): JsonResponse
    {
        $barangs = BarangModel::select(['barang_id', 'kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual'])->with('kategori');

        /**
         * Filter Barang data that we retrieve above base kategori_id retrieved in barang.index view
         */
        if ($request->kategori_id) {
            $barangs->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($barangs)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn  = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/barang/' . $barang->barang_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/barang/'.$barang->barang_id).'">'

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
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Barang baru'
        ];

        /**
         * Retrieve all column kategori_id data and kategori_nama from m_kategori for create foreign key in form
         */
        $kategoris = KategoriModel::select(['kategori_id', 'kategori_nama'])->get();

        /**
         * Set active menu
         */
        $activeMenu = 'barang';

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategoris' => $kategoris, 'activeMenu' => $activeMenu]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BarangResourceRequest $request): RedirectResponse
    {
        /**
         * Retrieve a portion of the validated input data...
         */
        $validated = $request->safe()->except('barang_id');

        /**
         * Created row m_barang Table data, base request form data
         */
        BarangModel::insert($validated);

        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $barang = BarangModel::with('kategori')->find($id);

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
        $activeMenu = 'barang';

        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang,'activeMenu' => $activeMenu]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        /**
         * Retrieve specific barang data with id
         */
        $barang = BarangModel::find($id);

        /**
         * Retrieve all kategori_id and kategori_nama for make user easy to edit m_barang tabel
         */
        $kategoris = KategoriModel::select(['kategori_id', 'kategori_nama'])->get();

        $breadcrumb = (object)[
            'title' => 'Edit Barang',
            'list' => ['Home', 'Barang', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Barang'
        ];

        /**
         * Set active menu
         */
        $activeMenu = 'barang';

        return view('barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategoris' => $kategoris, 'activeMenu' => $activeMenu]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BarangResourceRequest $request, string $id): RedirectResponse
    {
        /**
         * Retrieve a portion of the validated input data...
         */
        $validated = $request->safe()->except('barang_id');

        /**
         * Update row m_barang Table data, base request form data
         */
        BarangModel::where('barang_id', $id)->update($validated);

        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $check = BarangModel::find($id);

        /**
         * check whatever barang data with id is available or not
         */
        if (!$check) {
            return redirect('/barang')->with('error', 'Data Barang tidak ditemukan');
        }

        try {
            /**
             * Delete barang data
             */
            BarangModel::destroy($id);
            return redirect('/barang')->with('success', 'Data Barang berhasil dihapus');
        } catch (QueryException) {
            return redirect('/barang')->with('error', 'Data Barang gagal dihapus, karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}