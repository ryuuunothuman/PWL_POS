@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools">
                <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{session('error')}}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="">- Semua -</option>
                                @foreach ($kategoris as $item)
                                    <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori barang</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode</th>
                    <th>Kategori Barang</th>
                    <th>Nama</th>
                    <th>Harga Jual</th>
                    <th>Harga Beli</th>
                    <th>Aksi</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            var dataBarang = $('#table_barang').DataTable({
                serverSide: true, // True if we want to use Server side processing
                ajax: {
                    "url": "{{ url('barang/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.kategori_id = $('#kategori_id').val();
                    }
                },
                columns: [
                    {
                        data: "barang_id", // numbering from laravel datatables addIndexColumn() function
                        className: "text-center",
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: "barang_kode",
                        className: "text-center",
                        orderable: true,    // orderable: true, if we want this column is orderable
                        searchable: true,   // searchable: true, if we want this column searchable
                    },
                    {
                        data: "kategori.kategori_nama",
                        className: "text-center",
                        orderable: false,	// orderable: false, if we want this column not orderable
                        searchable: false	// searchable: false, if we want this column not searchable
                    },
                    {
                        data: "barang_nama",
                        className: "text-center",
                        orderable: true,    // orderable: true, if we want this column is orderable
                        searchable: true,   // searchable: true, if we want this column searchable
                    },
                    {
                        data: "harga_beli",
                        className: "text-center",
                        orderable: true,    // orderable: true, if we want this column is orderable
                        searchable: true,   // searchable: true, if we want this column searchable
                    },
                    {
                        data: "harga_jual",
                        className: "text-center",
                        orderable: true,    // orderable: true, if we want this column is orderable
                        searchable: true,   // searchable: true, if we want this column searchable
                    },
                    {
                        data: "aksi",
                        className: "",
                        orderable: false,	// orderable: false, if we want this column not orderable
                        searchable: false	// searchable: false, if we want this column not searchable
                    }
                ]
            });
            $('#kategori_id').on('change', function() {
                dataBarang.ajax.reload();
            });
        });
    </script>
@endpush