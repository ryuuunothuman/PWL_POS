@extends('layouts.app')

{{--Customize layout sections--}}

@section('subtitle', 'User')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'User')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage User</div>
            <div class="card-body">
                {{ $dataTable->table() }}
                <a class="btn btn-success" href="{{route('user.create')}}">Tambah User</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush