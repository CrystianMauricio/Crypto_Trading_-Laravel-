@if ($errors->any())
    <message :messages="{{ json_encode($errors->all()) }}" class="negative">
        {{ __('app.error') }}
    </message>
@elseif (session('error'))
    <message message="{{ session('error') }}" class="error">
        {{ __('app.error') }}
    </message>
@elseif (session('warning'))
    <message message="{{ session('warning') }}" class="warning">
        {{ __('app.warning') }}
    </message>
@elseif (session('success'))
    <message message="{{ session('success') }}" class="positive">
        {{ __('app.success') }}
    </message>
@elseif (session('status'))
    <message message="{{ session('status') }}" class="positive">
        {{ __('app.success') }}
    </message>
@elseif (session('info'))
    <message message="{{ session('info') }}" class="info">
        {{ __('app.info') }}
    </message>
@endif

@if (session('view'))
    @include(session('view'))
@endif