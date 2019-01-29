@extends('access.app', ['page_title' => 'Employees'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('employees.index') }}"><i class="fas fa-list"></i> Existing Employees</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Employee</legend>
        {!! Form::model(new App\AccEmployee, ['route' => ['employees.store'], 'class' => 'form-group']) !!}
            @include('access/employees/form', ['submit_text' => 'Create Employee'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
