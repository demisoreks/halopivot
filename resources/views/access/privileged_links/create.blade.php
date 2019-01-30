@extends('access.app', ['page_title' => 'Privileged Links'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('privileged_links.index') }}"><i class="fas fa-list"></i> Existing Privileged Links</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Privileged Link</legend>
        {!! Form::model(new App\AccPrivilegedLink, ['route' => ['privileged_links.store'], 'class' => 'form-group']) !!}
            @include('access/privileged_links/form', ['submit_text' => 'Create Privileged Link'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
