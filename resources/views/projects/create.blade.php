@extends('layouts.app')
@section('content')
    <h3 class="page-title">Projects</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['projects.store']]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            Create
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
                    {!! Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => 'Title...']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('title'))
                        <p class="help-block">
                            {{ $errors->first('title') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('path', 'Path to folder:', ['class' => 'control-label']) !!}
                    {!! Form::text('path', old('path'), ['class' => 'form-control', 'placeholder' => '/...']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('path'))
                        <p class="help-block">
                            {{ $errors->first('path') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('project_status_id', 'Project status*', ['class' => 'control-label']) !!}
                    {!! Form::select('project_status_id', $projectStatuses, old('project_status_id'), ['class' => 'form-control']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('project_status_id'))
                        <p class="help-block">
                            {{ $errors->first('project_status_id') }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('deployer', 'Deployers', ['class' => 'control-label']) !!}
                    {!! Form::select('deployer[]', $users, old('deployer'), ['class' => 'form-control select2', 'multiple' => 'multiple']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('deployer'))
                        <p class="help-block">
                            {{ $errors->first('deployer') }}
                        </p>
                    @endif
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit('Save', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@section('javascript')
    @parent
    <script>
        $('.date').datepicker({
            autoclose: true,
            dateFormat: "{{ config('app.date_format_js') }}"
        });
    </script>

@stop