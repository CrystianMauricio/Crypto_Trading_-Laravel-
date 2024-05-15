@extends('installer::layouts.install')

@section('content')
    <div class="column">
        <p>
            Admin user is successfully created. Current market data will now be retrieved from the CoinCap API.
            Please be patient, it might take some time.
        </p>
        <form class="ui form" method="POST" action="{{ route('install.process', ['step' => $step]) }}">
            {{ csrf_field() }}
            <button class="ui teal submit button">Next</button>
        </form>
    </div>
@endsection