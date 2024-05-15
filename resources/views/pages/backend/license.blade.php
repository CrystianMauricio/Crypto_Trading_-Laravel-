@extends('layouts.backend')

@section('title')
    {{ __('license.registration') }}
@endsection

@section('content')
    <div class="ui one column stackable grid container">
        @if(!env(FP_CODE) || !env(FP_EMAIL))
            <div class="column">
                <div class="ui warning message">
                    {{ __('license.warning') }}
                </div>
            </div>
        @endif
        <div class="column">
            <form class="ui {{ $inverted }} form" method="POST" action="{{ route('backend.license.register') }}">
                @csrf
                <div class="field">
                    <label>{{ __('license.purchase_code') }}</label>
                    <input type="text" name="code" placeholder="xxx-yyy-zzz" value="{{ old('code', env(FP_CODE)) }}" required>
                </div>
                <div class="field">
                    <label>{{ __('license.email') }}</label>
                    <input type="text" name="email" placeholder="someone@example.net" value="{{ old('email', env(FP_EMAIL)) }}" required>
                </div>
                <button class="ui {{ $settings->color }} submit button">{{ __('license.register') }}</button>
            </form>
        </div>
    </div>
@endsection
