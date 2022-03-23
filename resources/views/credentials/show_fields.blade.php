<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $credential->id }}</p>
</div>

<!-- Client Id Field -->
<div class="form-group">
    {!! Form::label('client_id', 'Client Id:') !!}
    <p>{{ $credential->client_id }}</p>
</div>

<!-- Client Secret Field -->
<div class="form-group">
    {!! Form::label('client_secret', 'Client Secret:') !!}
    <p>{{ $credential->client_secret }}</p>
</div>

<!-- Resource Field -->
<div class="form-group">
    {!! Form::label('resource', 'Resource:') !!}
    <p>{{ $credential->resource }}</p>
</div>

<!-- Grant Type Field -->
<div class="form-group">
    {!! Form::label('grant_type', 'Grant Type:') !!}
    <p>{{ $credential->grant_type }}</p>
</div>

<!-- Subscription Id Field -->
<div class="form-group">
    {!! Form::label('subscription_id', 'Subscription Id:') !!}
    <p>{{ $credential->subscription_id }}</p>
</div>

<!-- Tenant Field -->
<div class="form-group">
    {!! Form::label('tenant', 'Tenant:') !!}
    <p>{{ $credential->tenant }}</p>
</div>

<!-- Resource Group Field -->
<div class="form-group">
    {!! Form::label('resource_group', 'Resource Group:') !!}
    <p>{{ $credential->resource_group }}</p>
</div>

<!-- Resource Group Field -->
<div class="form-group">
    {!! Form::label('redirect_uri', 'Resource Group:') !!}
    <p>{{ $credential->redirect_uri }}</p>
</div>

<!-- Role Group Field -->
<div class="form-group">
    {!! Form::label('role_group', 'Role Group:') !!}
    <p>{{ $credential->role_group }}</p>
</div>

<!-- Active Field -->
<div class="form-group">
    {!! Form::label('active', 'Active:') !!}
    <p>{{ $credential->active }}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $credential->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $credential->updated_at }}</p>
</div>

