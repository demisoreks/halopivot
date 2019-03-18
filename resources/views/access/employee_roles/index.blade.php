@extends('access.app', ['page_title' => 'Permissions'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        Employee: {{ $employee->username }}
    </div>
</div>
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('employees.employee_roles.create', $employee->slug()) }}"><i class="fas fa-plus"></i> New Permission</a>
        <a class="btn btn-primary" href="{{ route('employees.index') }}"><i class="fas fa-arrow-left"></i> Back to Employees</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div id="accordion">
            <div class="card">
                <div class="card-header bg-white text-primary" id="heading1" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            <strong>Active</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapse1" class="collapse show" aria-labelledby="heading1" data-parent="#accordion">
                    <div class="card-body">
                        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th><strong>PRIVILEGED LINK | ROLE</strong></th>
                                    <th width="10%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee_roles as $employee_role)
                                    
                                <tr>
                                    <td>{{ $employee_role->role->privilegedLink->title }} | {{ $employee_role->role->title }}</td>
                                    <td class="text-center">
                                        <a title="Delete" href="{{ route('employees.employee_roles.delete', [$employee->slug(), $employee_role->slug()]) }}" onclick="return confirmDisable()"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection