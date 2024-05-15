<div class="ui four ordered steps">
    <div class="{{ $step == 1 ? 'active' : ($step > 1 ? 'completed' : '') }} step">
        <div class="content">
            <div class="title">Product</div>
            <div class="description">License registration</div>
        </div>
    </div>
    <div class="{{ $step == 2 ? 'active' : ($step > 2 ? 'completed' : '') }} step">
        <div class="content">
            <div class="title">Database</div>
            <div class="description">Database setup</div>
        </div>
    </div>
    <div class="{{ $step == 3 ? 'active' : ($step > 3 ? 'completed' : '') }} step">
        <div class="content">
            <div class="title">Administrator</div>
            <div class="description">Admin account setup</div>
        </div>
    </div>
    <div class="{{ $step == 4 ? 'active' : ($step > 4 ? 'completed' : '') }} step">
        <div class="content">
            <div class="title">Market data</div>
            <div class="description">Coins quotes refresh</div>
        </div>
    </div>
</div>