@extends('layouts.backend')

@section('title')
    {{ __('app.competitions') }} :: {{ __('app.bots_add') }}
@endsection

@section('content')
    <div class="ui stackable one column grid container">
        <div class="column">
            <div class="ui {{ $inverted }} segment">
                <form class="ui {{ $inverted }} form" method="POST" action="{{ route('backend.competitions.bots.add', $competition) }}">
                    @csrf
                    <div class="field {{ $errors->has('n') ? 'error' : '' }}">
                        <label>{{ __('app.bots_count') }}</label>
                        <div class="ui input">
                            <input type="number" name="n" placeholder="10" value="{{ old('n') }}" required autofocus>
                        </div>
                    </div>

                    <button class="ui large {{ $settings->color }} submit button">
                        <i class="plus icon"></i>
                        {{ __('app.add') }}
                    </button>
                </form>
            </div>
        </div>
        <div class="column">
            <a href="{{ route('backend.competitions.index') }}"><i class="left arrow icon"></i> {{ __('app.back_all_competitions') }}</a>
        </div>
    </div>
@endsection