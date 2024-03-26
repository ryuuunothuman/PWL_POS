@extends('layouts.app')

{{-- Customize layout sections  --}}
@section('subtitle', 'Level')
@section('content_header_title', 'Level')
@section('content_header_subtitle', 'Tambah')

{{-- Content body:main page content  --}}
@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Input Level</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form>
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputPassword1">Level Kode</label>
                    <input type="Number" class="form-control" id="exampleInputPassword1" placeholder="Input Level Kode">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Level Nama</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Input level Nama">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection