@extends('layouts.app')
@section('content')
    <h3 class="page-title" id="project_id" data-id="{{ $project->id }}">
        Deployment for project: <a href="http://stage.cf15.pro" target="_blank">http://stage.CF15.pro</a>
    </h3>

    @if(session('success'))
        <div class="row">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @else
        {!! Form::open(['method' => 'POST', 'route' => ['auth.change_password']]) !!}
        <p>
            {!! Form::button(trans('global.app_deploy'), ['class' => 'btn btn-danger deploy-start']) !!}
            &nbsp;&nbsp;&nbsp;&nbsp;
            {!! Form::button('Clear', ['class' => 'btn btn-primary deploy-clear']) !!}
        </p>
        <div class="panel panel-default">
            <div class="panel-heading">Deployment steps:</div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('gitPull', 'Step 1: Update codebase (command: git pull)', ['class' => 'control-label']) !!}
                        {!! Form::textarea('gitPull', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1]) !!}
                        <p class="help-block"></p>
                        @if($errors->has('current_password'))
                            <p class="help-block">
                                {{ $errors->first('current_password') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('composerInstall', 'Step 2: Update packages (command: composer install)', ['class' => 'control-label']) !!}
                        {!! Form::textarea('composerInstall', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1]) !!}
                        <p class="help-block"></p>
                        @if($errors->has('new_password'))
                            <p class="help-block">
                                {{ $errors->first('new_password') }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 form-group">
                        {!! Form::label('artisanMigrate', 'Step 3: Update database structure (command: php artisan migrate)', ['class' => 'control-label']) !!}
                        {!! Form::textarea('artisanMigrate', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => 1]) !!}
                        <p class="help-block"></p>
                        @if($errors->has('new_password_confirmation'))
                            <p class="help-block">
                                {{ $errors->first('new_password_confirmation') }}
                            </p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <p>
            {!! Form::button(trans('global.app_deploy'), ['class' => 'btn btn-danger deploy-start']) !!}
            &nbsp;&nbsp;&nbsp;&nbsp;
            {!! Form::button('Clear', ['class' => 'btn btn-primary deploy-clear']) !!}
        </p>
        {!! Form::close() !!}
    @endif
@stop
@section('javascript')
    <script src="{{ url('js/deploy.js') }}"></script>
@stop
