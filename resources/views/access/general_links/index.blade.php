@extends('access.app', ['page_title' => 'General Links'])

@section('content')
<div class="row">
    <div class="col-12" style="margin-bottom: 20px;">
        <a class="btn btn-primary" href="{{ route('general_links.create') }}"><i class="fas fa-plus"></i> New General Link</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div id="accordion1">
            <div class="card">
                <div class="card-header bg-secondary text-primary" id="heading3" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapse3">
                            Active
                        </button>
                    </h5>
                </div>
                <div id="collapse3" class="collapse show" aria-labelledby="heading3" data-parent="#accordion1">
                    <div class="card-body">
                        <table id="myTable1" class="display-1 table table-condensed table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="10%"><strong>ORDER NO.</strong></th>
                                    <th><strong>TITLE</strong></th>
                                    <th width="40%"><strong>URL</strong></th>
                                    <th width="10%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($general_links as $general_link)
                                    @if ($general_link->active)
                                <tr>
                                    <td class="text-right">{{ $general_link->order_no }}</td>
                                    <td>{{ $general_link->title }}</td>
                                    <td>{{ $general_link->url }}</td>
                                    <td class="text-center">
                                        <a title="Edit" href="{{ route('general_links.edit', [$general_link->slug()]) }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                                        <a title="Trash" href="{{ route('general_links.disable', [$general_link->slug()]) }}" onclick="return confirmDisable()"><i class="fas fa-trash"></i></a>
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
                <div class="card-header bg-secondary text-primary" id="heading4" style="padding: 0;">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
                            Inactive
                        </button>
                    </h5>
                </div>
                <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion1">
                    <div class="card-body">
                        <table id="myTable2" class="display-1 table table-condensed table-hover table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="10%"><strong>ORDER NO.</strong></th>
                                    <th><strong>TITLE</strong></th>
                                    <th width="40%"><strong>URL</strong></th>
                                    <th width="10%">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($general_links as $general_link)
                                    @if (!$general_link->active)
                                <tr>
                                    <td class="text-right">{{ $general_link->order_no }}</td>
                                    <td>{{ $general_link->title }}</td>
                                    <td>{{ $general_link->url }}</td>
                                    <td class="text-center">
                                        <a title="Restore" href="{{ route('general_links.enable', [$general_link->slug()]) }}"><i class="fas fa-undo"></i></a>
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