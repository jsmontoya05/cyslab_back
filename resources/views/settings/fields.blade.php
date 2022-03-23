<!-- Main Color Field -->
<div class="form-group col-sm-6">
    {!! Form::label('main_color', 'Color Principal:') !!}
    {!! Form::color('main_color', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 50]) !!}
</div>

<!-- Main Color Field -->
<div class="form-group col-sm-6">
    {!! Form::label('text_color', 'Color Princial Texto:') !!}
    {!! Form::color('text_color', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 50]) !!}
</div>

<!-- Logo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('logo', 'Logo:') !!}
    @if(isset($setting->logo))
    <img src="data:image/png;base64,{{$setting->logo}}" alt="logo" width="100" />
    @endif
    <input name="logo" type="file" id="logo" class="form-control">
</div>

<!-- Ip Check Middleware Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ip_check_middleware', 'Ip Verificada:') !!}
    {!! Form::text('ip_check_middleware', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255]) !!}
</div>

<!-- Route Spa Apllication Field -->
<div class="form-group col-sm-6">
    {!! Form::label('route_spa_application', ' Dirección De Applicación Frontend:') !!}
    {!! Form::text('route_spa_application', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255]) !!}
</div>

<!-- Active Field -->
<div class="form-group col-sm-6">
    {!! Form::label('active', 'Estado:') !!}
    {!! Form::select('active',[1 => 'Activo', 0 => 'Inactivo'],null,['class'=>'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('settings.index') }}" class="btn btn-light">Cancelar</a>
</div>
