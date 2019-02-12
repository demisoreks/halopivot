@extends('access.app', ['page_title' => 'Permissions', 'nest' => 1])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        Employee: {{ $employee->username }}
    </div>
</div>
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('employees.employee_roles.index', $employee->slug()) }}"><i class="fas fa-list"></i> Existing Permissions</a>
        <a class="btn btn-primary" href="{{ route('employees.index') }}"><i class="fas fa-arrow-left"></i> Back to Employees</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <legend>New Permission</legend>
        {!! Form::model(new App\AccEmployeeRole, ['route' => ['employees.employee_roles.store', $employee->slug()], 'class' => 'form-group']) !!}
            @include('access/employee_roles/form', ['submit_text' => 'Create Permission'])
        {!! Form::close() !!}
    </div>
</div>
@endsection
