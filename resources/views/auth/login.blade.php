@extends('layouts.auth')

@section('title')
    {{ __('auth.login') }}
@endsection

@section('before-auth')
    <div id="particles"></div>
@endsection

@section('auth')
    <div class="ui middle aligned center aligned grid centered-container">
        <div class="column">
            <div class="ui segment">
                <h2 class="ui {{ $settings->color }} image header">
                    <a href="{{ route('frontend.index') }}">
                        <img src="{{ asset('images/logo.png') }}" class="image">
                    </a>
                    <div class="content">
                        {{ __('app.app_name') }}
                        <div class="sub header">{{ __('auth.login_header') }}</div>
                    </div>
                </h2>
                @component('components.session.messages')
                @endcomponent
                <loading-form v-cloak inline-template>
                    <form class="ui form" method="POST" action="{{ route('login') }}" @submit="disableButton">
                        {{ csrf_field() }}
                        <div class="field">
                            <div class="ui left icon input">
                                <i class="mail icon"></i>
                                <input type="email" name="email" placeholder="{{ __('auth.email') }}" value="{{ old('email') }}" required autofocus>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui left icon input">
                                <i class="key icon"></i>
                                <input type="password" name="password" placeholder="{{ __('auth.password') }}" required>
                            </div>
                        </div>
                        <div class="left aligned field">
                            <div class="ui checkbox">
                                <input type="checkbox" name="remember" tabindex="0" class="hidden" {{ old('remember') ? 'checked="checked"' : '' }}>
                                <label>{{ __('auth.remember') }}</label>
                            </div>
                        </div>
                        @if(config('settings.recaptcha.public_key'))
                            <div class="field">
                                <div class="g-recaptcha" data-sitekey="{{ config('settings.recaptcha.public_key') }}" data-theme="{{ $inverted ? 'dark' : 'light' }}"></div>
                            </div>
                        @endif
                        <button :class="[{disabled: submitted, loading: submitted}, 'ui {{ $settings->color }} fluid large submit button']">{{ __('auth.login') }}</button>
                    </form>
                </loading-form>
                @social
                    <div id="social-login-divider" class="ui horizontal divider">
                        {{ __('auth.social_login') }}
                    </div>
                    <div>
                        @social('facebook')
                            <a href="{{ url('login/facebook') }}" class="ui circular facebook icon button">
                                <i class="facebook icon"></i>
                            </a>
                        @endsocial
                        @social('twitter')
                            <a href="{{ url('login/twitter') }}" class="ui circular twitter icon button">
                                <i class="twitter icon"></i>
                            </a>
                        @endsocial
                        @social('linkedin')
                            <a href="{{ url('login/linkedin') }}" class="ui circular linkedin icon button">
                                <i class="linkedin icon"></i>
                            </a>
                        @endsocial
                        @social('google')
                            <a href="{{ url('login/google') }}" class="ui circular google plus icon button">
                                <i class="google plus icon"></i>
                            </a>
                        @endsocial
                    </div>
                @endsocial
            </div>

            <div class="ui message">
                <div>{{ __('auth.sign_up_question') }} <a href="{{ route('register') }}">{{ __('auth.sign_up') }}</a></div>
                <div class="ui divider"></div>
                <div>{{ __('auth.forgot_password') }} <a href="{{ route('password.request') }}">{{ __('auth.reset') }}</a></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ asset('js/auth.js') }}"></script>
    @if(config('settings.recaptcha.public_key'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
@endpush