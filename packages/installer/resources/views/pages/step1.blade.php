@extends('installer::layouts.install')

@section('content')
    <div class="column">
        <p>Please activate your product license.</p>
        <form class="ui form" method="POST" action="{{ route('install.process', ['step' => $step]) }}">
            {{ csrf_field() }}
            <div class="six wide field">
                <label>Purchase code</label>
                <input type="text" name="code" placeholder="Purchase code" value="{{ old('code', env('FP_CODE')) }}" required>
            </div>
            <div class="six wide field">
                <label>License holder email</label>
                <input type="text" name="email" placeholder="Email" value="{{ old('email', env(FP_EMAIL)) }}" required>
            </div>
            <button class="ui teal submit button">Next</button>
        </form>
    </div>
@endsection
