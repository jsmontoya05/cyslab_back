@extends('layouts.app')
@section('title')
    Credenciales
@endsection
@section('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Credenciales</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('credentials.create')}}" class="btn btn-primary form-btn">Credenciales <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('credentials.table')
                    @include('credentials.templates.templates')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{mix('assets/js/credentials/credentials.js')}}"></script>
@endsection
