@extends('layouts.frontend')

@section('title')
    {{ __('app.chat') }}
@endsection

@section('content')
    <div class="ui one column tablet stackable grid container">
        <div class="column">
            <chat :user="{{ json_encode(['id' => auth()->user()->id, 'name' => auth()->user()->name]) }}"></chat>
        </div>
    </div>
@endsection