<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('includes.frontend.head')
</head>
<body class="{{ str_replace('.','-',Route::currentRouteName()) }} background-{{ $settings->background }} color-{{ $settings->color }}">
    @includeWhen(config('settings.gtm_container_id'), 'includes.frontend.gtm-body')

    <div id="particles"></div>

    <div id="error">
        <div class="ui middle aligned center aligned grid centered-container">
            <div class="column">
                <div class="ui segment">
                    <h2 class="ui {{ $settings->color }} image header">
                        <a href="{{ route('frontend.index') }}">
                            <img src="{{ asset('images/logo.png') }}" class="image">
                        </a>
                        <div class="content">
                            {{ __('app.app_name') }}
                            <div class="sub header">{{ __('error.title') }}</div>
                        </div>
                    </h2>
                    <div class="ui {{ $settings->color }} {{ $inverted }} statistic">
                        <div class="value">
                            {{ $exception->getStatusCode() }}
                        </div>
                        <div class="label">
                            {{ __('error.' . $exception->getStatusCode()) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/manifest.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/vendor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/semantic/semantic.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/auth.js') }}"></script>
</body>
</html>
