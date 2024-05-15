@extends('installer::layouts.install')

@section('content')
    <div class="column">
        <p>Congratulations! Installation is completed and <b>{{ config('app.name') }}</b> is now up and running.</p>
        <p>
            In order for the application and all services to work correctly please add the following cron job to your server
            (if you add the cron job via cPanel you need to omit the leading asterisk symbols):
        </p>
        <div class="ui teal message">
            <pre>{{ \App\Helpers\Utils::getCronJobCommand() }}</pre>
        </div>
        <div class="ui hidden divider"></div>
        <a href="{{ route('frontend.index') }}" class="ui teal button" target="_blank">Front page</a>
        <a href="{{ route('login') }}" class="ui teal button" target="_blank">Log in</a>
    </div>
@endsection
