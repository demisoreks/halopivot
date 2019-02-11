@extends('access.app', ['page_title' => 'Roles', 'nest' => 1])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        Title: {{ $privileged_link->title }}
    </div>
</div>
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('privileged_links.roles.index', $privileged_link->slug()) }}"><i class="fas fa-list"></i> Existing Roles</a>
        <a class="btn btn-primary" href="{{ route('privileged_links.index') }}"><i class="fas fa-arrow-left"></i> Back to Privileged Links</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Role</legend>
        {!! Form::model(new App\AccRole, ['route' => ['privileged_links.roles.store', $privileged_link->slug()], 'class' => 'form-group']) !!}
            @include('access/roles/form', ['submit_text' => 'Create Role'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
