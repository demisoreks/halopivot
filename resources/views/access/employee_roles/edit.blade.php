@extends('access.app', ['page_title' => 'Roles', 'nest' => 2])

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
        <legend>Edit Role</legend>
        {!! Form::model($role, ['route' => ['privileged_links.roles.update', $privileged_link->slug(), $role->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('access/roles/form', ['submit_text' => 'Update Role'])
        {!! Form::close() !!}
    </div>
</div>
@endsection