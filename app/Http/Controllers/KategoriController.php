<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $datatable)
    {
        return $datatable->render('kategori.index');
    }

    public function create(): View
    {
        return view('kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_kode' => 'bail|unique:m_kategori|required',
            'kategori_nama' => 'bail|required|max:255',
        ]);

        // KategoriModel::create($validated);

        return redirect('/kategori');
    }

    /**
     * Return to edit page
     */
    function edit($id) {
        return view('kategori.edit', ['data' => KategoriModel::find($id)]);
    }

    /**
     * Update kategori data
     */
    public function update(Request $request, $id)
    {
        $kategori = KategoriModel::find($id);
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->kategori_nama = $request->kategori_nama;

        $kategori->save();
        return redirect('/kategori');
    }

    function destroy($id) {
        KategoriModel::find($id)->delete();

        return redirect('/kategori');
    }
}
