<div id="header-mobile" class="ui fluid fixed borderless menu">
    <div class="ui container">
        <a class="item" @click="mobileMenuShown = !mobileMenuShown">
            <i class="sidebar icon"></i>
        </a>
        <span class="item">Elegon</span>
    </div>
</div>

<div id="header" class="ui stackable fixed menu" :class="{'hidden-mobile': !mobileMenuShown}" v-cloak>
    <div class="ui container">

        {{-- Left side of the menu --}}
        <a class="item" href="{{ route('dashboard') }}">
            <i class="space shuttle icon"></i> {{ config('app.name', 'Elegon') }}
        </a>

        <a class="item">
            <i class="grid layout icon"></i> Browse
        </a>

        {{-- Right side of the menu --}}
        <div class="right menu">

            @if (Auth::guest())

                {{-- Guest --}}
                <a class="item" href="{{ route('login') }}">Login</a>
                <a class="item" href="{{ route('register') }}">Register</a>

            @else

                {{-- Authenticated --}}
                @include('layouts.app.header.user')
                
            @endif
        </div>
    </div>
</div>
