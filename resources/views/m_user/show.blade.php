@extends('layouts.app')

{{-- Customize layout sections  --}}
@section('subtitle', 'M_User')
@section('content_header_title', 'M_User')
@section('content_header_subtitle', 'Show')

@section('content')
<div class="container">
    <div class="card card-info">
        <div class="card-header">Edit Level</div>
        <div class="card-body">
            <a class="btn btn-secondary" href="{{ route('m_user.index') }}">
                Kembali</a>
        </div>
        <div>
            <table class="table table-bordered">
                <tr>
                    <td><strong>User_id:</strong></td>
                    <td>{{ $useri->user_id }}</td>
                </tr>
                <tr>
                    <td><strong>Level_id:</strong></td>
                    <td>{{ $useri->level_id }}</td>
                </tr>
                <tr>
                    <td><strong>Level Kode:</strong></td>
                    <td>{{ $useri->level->level_kode }}</td>
                </tr>
                <tr>
                    <td><strong>Level Nama:</strong></td>
                    <td>{{ $useri->level->level_nama }}</td>
                </tr>
                <tr>
                    <td><strong>Username:</strong></td>
                    <td>{{ $useri->username }}</td>
                </tr>
                <tr>
                    <td><strong>Nama:</strong></td>
                    <td>{{ $useri->nama }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection