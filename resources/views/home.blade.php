@extends('layouts.app')
@section('content')
    @if(session('success'))
        <!-- If password successfully show message -->
        <div class="row">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @else
        <h2>Hello, {{ Auth::user()->name }}</h2>
        <div class="panel panel-default">
            <div class="panel-heading">Info</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::label('txt', 'Your last login: '. Auth::user()->updated_at, ['class' => 'control-label']) !!}
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
