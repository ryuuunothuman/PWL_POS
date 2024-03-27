@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Kategori')
@section('content_header_title', 'Kategori')
@section('content_header_subtitle', 'Create')

{{-- Content body: main page content --}}
@section('content')
    <div class="container">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Buat Kategori baru</h3>
            </div>

            <form method="post" action="../kategori">
                <div class="card-body">
                    <div class="form-group">
                        <label for="kategori_kode">Kode Kategori</label>
                        <input type="text" class="form-control" id="kategori_kode" name="kategori_kode" placeholder="">
                    </div>
                    @error('kategori_kode')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror                    
                    <div class="form-group">
                        <label for="kategori_nama">Nama Kategori</label>
                        <input type="text" class="form-control @error('kategori_nama') is-invalid @enderror" id="kategori_nama" name="kategori_nama" placeholder="">
                    </div>
                    @error('kategori_nama')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror 

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
        </div>
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
        </form>
    </div>
@endsection