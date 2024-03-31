@extends('layouts.app')

@section('subtitle', 'M_User')
@section('content_header_title', 'M_User')
@section('content_header_subtitle', 'Create')

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Input User</h3>
        </div>
    </div>
    <div class="float-right mt-3 ms-3">
        <a class="btn btn-secondary" href="{{ route('m_user.index') }}"> Kembali</a>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('m_user.store') }}">
            
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Input Username">

                    @error('username')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama">nama</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Input Nama">

                    @error('nama')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Input Password">

                    @error('password')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="level_id">level_id</label>
                    <input type="number" name="level_id" class="form-control @error('level_id') is-invalid @enderror" id="level_id" placeholder="Input Level Id">

                    @error('level_id')
                    <div class="alert alert-danger">{{$message}}</div>
                    @enderror
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection