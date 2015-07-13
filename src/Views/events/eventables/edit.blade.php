@extends('maintenance::layouts.pages.main.panel')

@section('title', 'Edit Event')

@section('panel.head.content')
    Edit Event
@stop

@section('panel.body.content')

    {!!
        Form::open([
            'url' => route($routes['update'], [$eventable->id, $event->id]),
            'method' => 'PATCH',
            'class' => 'form-horizontal'
        ])
    !!}

    @include('maintenance::events.form', [
        'event' => $event
    ])

    {!! Form::close() !!}

@stop
