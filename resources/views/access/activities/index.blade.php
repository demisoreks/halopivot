@extends('access.app', ['page_title' => 'Activities'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="alert alert-info" role="alert">
            <strong>NB:</strong> This page shows only the latest 1,000 records. Kindly contact the IT administrator for full activity log.
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table id="myTable3" class="display-1 table table-condensed table-hover table-striped">
            <thead>
                <tr class="text-center">
                    <th width="15%"><strong>TIME OF ACTIVITY</strong></th>
                    <th><strong>ACTIVITY DETAIL</strong></th>
                    <th width="20%"><strong>EMPLOYEE</strong></th>
                    <th width="15%"><strong>SOURCE</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                <tr>
                    <td class="text-center">{{ $activity->created_at }}</td>
                    <td>{{ $activity->detail }}</td>
                    <td>{{ $activity->employee->username }}</td>
                    <td>{{ $activity->source_ip }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection