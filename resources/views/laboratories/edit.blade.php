@extends('layouts.app')
@section('title')
    Edit Laboratory 
@endsection
@section('content')
    <section class="section">
            <div class="section-header">
                <h3 class="page__heading m-0">Edit Laboratory</h3>
                <div class="filter-container section-header-breadcrumb row justify-content-md-end">
                    <a href="{{ route('laboratories.index') }}"  class="btn btn-primary">Back</a>
                </div>
            </div>
  <div class="content">
              @include('stisla-templates::common.errors')
              <div class="section-body">
                 <div class="row">
                     <div class="col-lg-12">
                         <div class="card">
                             <div class="card-body ">
                                    {!! Form::model($laboratory, ['route' => ['laboratories.update', $laboratory->id], 'method' => 'patch']) !!}
                                        <div class="row">
                                            @include('laboratories.fields')
                                        </div>

                                    {!! Form::close() !!}
                            </div>
                         </div>
                    </div>
                 </div>
              </div>
   </div>
  </section>
@endsection
