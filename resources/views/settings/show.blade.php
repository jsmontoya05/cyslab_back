@extends('layouts.app')
@section('title')
    Detalle de Configuración
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
        <h1>Detalle de Configuración</h1>
        <div class="section-header-breadcrumb">
            <a href="{{ route('settings.index') }}"
                 class="btn btn-primary form-btn float-right">Atras</a>
        </div>
      </div>
   @include('stisla-templates::common.errors')
    <div class="section-body">
           <div class="card">
            <div class="card-body">
                    @include('settings.show_fields')
            </div>
            </div>
    </div>
    </section>
@endsection
