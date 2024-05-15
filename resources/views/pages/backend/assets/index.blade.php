@extends('layouts.backend')

@section('title')
  {{ __('app.assets') }}
@endsection

@section('content')
  <div class="ui stackable grid container">
    <div class="eight wide left aligned column">
      <a href="{{ route('backend.assets.create') }}" class="ui {{ $settings->color }} button">
        <i class="bitcoin icon"></i>
        {{ __('app.create_asset') }}
      </a>
    </div>
    <div class="eight wide right aligned column">
      <form method="GET" action="{{ route('backend.assets.index') }}">
        <div class="ui action input">
          <input type="text" name="search" placeholder="{{ __('app.symbol') }}" value="{{ $search }}">
          <button class="ui {{ $settings->color }} button">{{ __('app.search') }}</button>
        </div>
      </form>
    </div>
  </div>
  <div class="ui stackable one column grid container">
    <div class="column">
      @if($assets->isEmpty())
        <div class="ui segment">
          <p>{{ __('app.assets_empty') }}</p>
        </div>
      @else
        <table class="ui selectable tablet stackable {{ $inverted }} table">
          <thead>
            <tr>
              @component('components.tables.sortable-column', ['id' => 'id', 'sort' => $sort, 'order' => $order, 'search' => $search])
                {{ __('app.id') }}
              @endcomponent
              @component('components.tables.sortable-column', ['id' => 'symbol', 'sort' => $sort, 'order' => $order])
                {{ __('app.symbol') }}
              @endcomponent
              @component('components.tables.sortable-column', ['id' => 'name', 'sort' => $sort, 'order' => $order])
                {{ __('app.name') }}
              @endcomponent
              @component('components.tables.sortable-column', ['id' => 'price', 'sort' => $sort, 'order' => $order])
                {{ __('app.price') }}
              @endcomponent
              @component('components.tables.sortable-column', ['id' => 'change_abs', 'sort' => $sort, 'order' => $order])
                {{ __('app.change_abs') }}
              @endcomponent
              @component('components.tables.sortable-column', ['id' => 'change_pct', 'sort' => $sort, 'order' => $order])
                {{ __('app.change_pct') }}
              @endcomponent
              @component('components.tables.sortable-column', ['id' => 'status', 'sort' => $sort, 'order' => $order])
                {{ __('app.status') }}
              @endcomponent
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($assets as $asset)
              <tr>
                <td data-title="{{ __('app.id') }}">{{ $asset->id }}</td>
                <td data-title="{{ __('app.symbol') }}">
                  <a href="{{ route('backend.assets.edit', $asset) }}" class="nowrap">
                    <img src="{{ $asset->logo_url }}" class="ui avatar image">
                    {{ $asset->symbol }}
                  </a>
                </td>
                <td data-title="{{ __('app.name') }}">
                  <a href="{{ route('backend.assets.edit', $asset) }}">
                    {{ $asset->name }}
                  </a>
                </td>
                <td data-title="{{ __('app.price') }}">{{ $asset->_price }}</td>
                <td data-title="{{ __('app.change_abs') }}" class="{{ $asset->change_abs > 0 ? 'positive' : ($asset->change_abs < 0 ? 'negative' : '') }}">{{ $asset->_change_abs }}</td>
                <td data-title="{{ __('app.change_pct') }}" class="{{ $asset->change_pct > 0 ? 'positive' : ($asset->change_pct < 0 ? 'negative' : '') }}">{{ $asset->_change_pct }}</td>
                <td data-title="{{ __('app.status') }}">
                  <i class="{{ $asset->status == App\Models\Asset::STATUS_ACTIVE ? 'check green' : 'red ban' }} large icon"></i> {{ __('app.asset_status_' . $asset->status) }}
                </td>
                <td class="right aligned tablet-and-below-center">
                  <a class="ui icon {{ $settings->color }} basic button" href="{{ route('backend.assets.edit', $asset) }}">
                    <i class="edit icon"></i>
                    {{ __('app.edit') }}
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
    <div class="right aligned column">
      {{ $assets->appends(['sort' => $sort, 'order' => $order, 'search' => $search])->links() }}
    </div>
  </div>
@endsection
