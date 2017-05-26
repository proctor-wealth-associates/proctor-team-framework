
@if (session('flash_notification'))
    <div class="ui container stackable grid">
        <div class="column" style="padding: 0 1rem;">
            @include('flash::message', [ 'style' => 'margin: 1rem 0;' ])
        </div>
    </div>
@endif
