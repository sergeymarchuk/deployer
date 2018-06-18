@extends('layouts.app')
@section('content')
    <h3 class="page-title">Deployment of project</h3>

    @if(session('success'))
        <!-- If password successfully show message -->
        <div class="row">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @else
        {!! Form::open(['method' => 'POST', 'route' => ['auth.change_password']]) !!}
        <!-- If no success message in flash session show change password form  -->
        <p>{!! Form::button(trans('global.app_deploy'), ['class' => 'btn btn-danger deploy-start']) !!}</p>
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

        {!! Form::button(trans('global.app_deploy'), ['class' => 'btn btn-danger deploy-start']) !!}
        {!! Form::close() !!}
    @endif
@stop
@section('javascript')
    <script src="{{ url('js/deploy.js') }}"></script>
@stop
