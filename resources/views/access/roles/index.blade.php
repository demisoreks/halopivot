@extends('access.app', ['page_title' => 'Roles'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        Privileged Link: {{ $privileged_link->title }}
    </div>
</div>
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('privileged_links.roles.create', $privileged_link->slug()) }}"><i class="fas fa-plus"></i> New Role</a>
        <a class="btn btn-primary" href="{{ route('privileged_links.index') }}"><i class="fas fa-arrow-left"></i> Back to Privileged Links</a>
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
                                    <th><strong>TITLE</strong></th>
                                    <th width="10%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    @if ($role->active)
                                <tr>
                                    <td>{{ $role->title }}</td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('privileged_links.roles.edit', [$privileged_link->slug(), $role->slug()]) }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                                        <a title="Trash" href="{{ route('privileged_links.roles.disable', [$privileged_link->slug(), $role->slug()]) }}" onclick="return confirmDisable()"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
            <div class="card">
                <div class="card-header bg-white text-primary" id="heading2" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
                            <strong>Inactive</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
                    <div class="card-body">
                        <table id="myTable2" class="display-1 table table-condensed table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th><strong>TITLE</strong></th>
                                    <th width="10%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    @if (!$role->active)
                                <tr>
                                    <td>{{ $role->title }}</td>
                                    <td class="text-center">
                                        <a title="Restore" href="{{ route('privileged_links.roles.enable', [$privileged_link->slug(), $role->slug()]) }}"><i class="fas fa-undo"></i></a>
                                    </td>
                                </tr>
                                    @endif
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