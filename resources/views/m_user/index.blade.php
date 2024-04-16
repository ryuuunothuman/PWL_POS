@extends('layouts.app')

{{--Customize layout sections--}}
@section('subtitle', 'M_User')
@section('content_header_title', 'Hompppppe')
@section('content_header_subtitle', 'M_Userrrrr')

@section('content')
<div class="container">
    <div class="card card-info">
        <div class="card-header">CRUD m_user</div>
        <div class="card-body">
            {{ $dataTable->table() }}
            <div class="float-right">
                <a href="{{ route('m_user.create') }}" class="btn btn-success">
                    Input User</a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    {{ $dataTable->scripts() }}
@endpush