@extends('layouts.app')
@section('title')
    Detalle De Credenciales 
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Detalle De Credenciales</h1>
        <div class="section-header-breadcrumb">
            <a href="{{ route('credentials.index') }}"
                 class="btn btn-primary form-btn float-right">Atras</a>
        </div>
      </div>
   @include('stisla-templates::common.errors')
    <div class="section-body">
           <div class="card">
            <div class="card-body">
                    @include('credentials.show_fields')
            </div>
            </div>
    </div>
    </section>
@endsection
