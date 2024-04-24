@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('level/create') }}">Tambah</a>
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
                        <select name="level_id" id="level_id" class="form-control" required>
                            <option value="">- Semua -</option>
                            @foreach ($levels as $item)
                                <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Level Nama</small>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_level">
            <thead>
            <tr>
                <th>ID</th>
                <th>Level Kode</th>
                <th>Level Nama</th>
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
            var dataUser = $('#table_level').DataTable({
                serverSide: true, // True if we want to use Server side processing
                ajax: {
                    "url": "{{ url('level/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function (d) {
                        d.level_id = $('#level_id').val();
                    }
                },
                columns: [
                    {
                        data: "DT_RowIndex", // numbering from laravel datatables addIndexColumn() function
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: "level_kode",
                        className: "",
                        orderable: true,    // orderable: true, if we want this column is orderable
                        searchable: true,   // searchable: true, if we want this column searchable
                    },
                    {
                        data: "level_nama",
                        className: "",
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
            $('#level_id').on('change', function() {
                dataUser.ajax.reload();
            });
        });
    </script>
@endpush