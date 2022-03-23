<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $setting->id }}</p>
</div>

<!-- Main Color Field -->
<div class="form-group">
    {!! Form::label('main_color', 'Main Color:') !!}
    <p>{{ $setting->main_color }}</p>
</div>

<!-- Text Color Field -->
<div class="form-group">
    {!! Form::label('text_color', 'Text Color:') !!}
    <p>{{ $setting->text_color }}</p>
</div>

<!-- Logo Field -->
<div class="form-group">
    {!! Form::label('logo', 'Logo:') !!}
    <p>{{ $setting->logo }}</p>
</div>

<!-- Ip Check Middleware Field -->
<div class="form-group">
    {!! Form::label('ip_check_middleware', 'Ip Check Middleware:') !!}
    <p>{{ $setting->ip_check_middleware }}</p>
</div>

<!-- Route Spa Application -->
<div class="form-group">
    {!! Form::label('route_spa_application', 'Route Spa Application') !!}
    <p>{{ $setting->route_spa_application }}</p>
</div>

<!-- Active Field -->
<div class="form-group">
    {!! Form::label('active', 'Active:') !!}
    <p>{{ $setting->active }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $setting->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $setting->updated_at }}</p>
</div>

