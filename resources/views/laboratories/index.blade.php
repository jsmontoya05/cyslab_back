@extends('layouts.app')
@section('title')
    Laboratories
@endsection
@section('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Laboratories</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('laboratories.create')}}" class="btn btn-primary form-btn">Laboratory <i class="fas fa-plus"></i></a>
            </div>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('laboratories.table')
                    @include('laboratories.templates.templates')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ mix('assets/js/laboratories/laboratories.js')}}"></script>
@endsection
