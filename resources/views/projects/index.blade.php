@extends('layouts.app')
@section('content')
    <h3 class="page-title">Projects</h3>
    @can('projects_manage')
        <p><a href="{{ route('projects.create') }}" class="btn btn-success">Add new</a></p>
    @endcan
    <div class="panel panel-default">
        <div class="panel-heading">List</div>
        <div class="panel-body">
            <table class="table table-bordered table-striped {{ count($projects) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        <th>Project Name</th>
                        <th>Last deployer</th>
                        <th>Last deploy</th>
                        <th>Project status</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($projects) > 0)
                        @foreach ($projects as $project)
                            <tr data-entry-id="{{ $project->id }}">
                                <td></td>
                                <td><a href="{{ route('projects.deploy',[$project->id]) }}">{{ $project->title }}</a></td>
                                <td>{{ $project->client->first_name or '' }}</td>
                                <td>{{ $project->start_date }}</td>
                                <td>{{ $project->projectStatus->title or '' }}</td>
                                <td>
                                    @can('deploy')
                                        <a href="{{ route('projects.deploy',[$project->id]) }}" class="btn btn-xs btn-success">Deploy</a>
                                    @endcan
                                    @can('projects_manage')
                                        <a href="{{ route('projects.show',[$project->id]) }}" class="btn btn-xs btn-primary">View</a>
                                        <a href="{{ route('projects.edit',[$project->id]) }}" class="btn btn-xs btn-info">Edit</a>
                                        {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("Are you sure?")."');",
                                        'route' => ['projects.destroy', $project->id])) !!}
                                        {!! Form::submit('Delete', array('class' => 'btn btn-xs btn-danger')) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">No entries in table</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    @can('projects_manage')
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('projects.mass_destroy') }}';
    </script>
    @endcan
@endsection
