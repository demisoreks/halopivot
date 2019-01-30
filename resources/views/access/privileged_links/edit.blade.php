@extends('access.app', ['page_title' => 'Privileged Links'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('privileged_links.index') }}"><i class="fas fa-list"></i> Existing Privileged Links</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>Edit Privileged Link</legend>
        {!! Form::model($privileged_link, ['route' => ['privileged_links.update', $privileged_link->slug()], 'class' => 'form-group']) !!}
        @method('PUT')
        @include('access/privileged_links/form', ['submit_text' => 'Update Privileged Link'])
        {!! Form::close() !!}
    </div>
</div>
@endsection