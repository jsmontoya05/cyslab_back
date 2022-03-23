<!-- Client Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('client_id', 'Id Del Cliente: (id de la applicacion en azure)') !!}
    {!! Form::text('client_id', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255]) !!}
</div>

<!-- Client Secret Field -->
<div class="form-group col-sm-6">
    {!! Form::label('client_secret', 'Clave Secreta Del Cliente: (clave del secreto creado en "App registrations")') !!}
    {!! Form::text('client_secret', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255]) !!}
</div>

<!-- Resource Field -->
<div class="form-group col-sm-6">
    {!! Form::label('resource', 'Recurso Apirest: (por defecto "https://management.azure.com/")') !!}
    {!! Form::text('resource', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255]) !!}
</div>

<!-- Grant Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('grant_type', 'Tipo De Subvención: (por defecto "client_credentials")') !!}
    {!! Form::text('grant_type', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255]) !!}
</div>

<!-- Subscription Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subscription_id', 'ID De Suscripción: (id de la suscripción de azure)') !!}
    {!! Form::text('subscription_id', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255]) !!}
</div>

<!-- Tenant Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tenant', 'ID Del Inquilino: (id del tenant)') !!}
    {!! Form::text('tenant', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255]) !!}
</div>

<!-- Resource Group Field -->
<div class="form-group col-sm-6">
    {!! Form::label('resource_group', 'Grupo de Recurso: (grupo de recursos que tenga permiso de contributor por parte del "App registrations")') !!}
    {!! Form::text('resource_group', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255]) !!}
</div>

<!-- Redirect Uri Field -->
<div class="form-group col-sm-6">
    {!! Form::label('redirect_uri', 'Redirección De Oauth: ("{URL-BACKENDCYSLAB-WITH-HTTPS}/callback", ejemplo => "https://cyslab-backend.test/callback")') !!}
    {!! Form::text('redirect_uri', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255]) !!}
</div>

<!-- Role Group Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role_group', 'Grupo Rol: (permiso para entrar al aplicativo)') !!}
    {!! Form::text('role_group', null, ['class' => 'form-control','minlength' => 2,'maxlength' => 255]) !!}
</div>

<!-- Active Field -->
<div class="form-group col-sm-6">
    {!! Form::label('active', 'Estado:') !!}
    {!! Form::select('active',[1 => 'Activo', 0 => 'Inactivo'],null,['class'=>'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('credentials.index') }}" class="btn btn-light">Cancelar</a>
</div>
