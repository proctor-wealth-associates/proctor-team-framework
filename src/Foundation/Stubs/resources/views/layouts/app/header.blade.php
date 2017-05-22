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
                <a class="item" href="{{ route('login') }}">Login</a>
                <a class="item" href="{{ route('register') }}">Register</a>
            @else
                <div class="ui simple dropdown item">
                    <img class="ui avatar image" src="{{ Auth::user()->photo_url }}">
                    {{ Auth::user()->name }}
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <a class="item" href="{{ route('user.show', Auth::user()) }}">
                            <i class="user outline icon"></i> See Profile
                        </a>
                        <a class="item" href="{{ route('user.edit', Auth::user()) }}">
                            <i class="edit icon"></i> Edit Profile
                        </a>
                        <div class="divider"></div>
                        <a  class="item" 
                            href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        >
                            <i class="sign out icon"></i> Logout
                            <form 
                                id="logout-form" 
                                action="{{ route('logout') }}" 
                                method="POST" 
                                style="display: none;"
                            >
                                {{ csrf_field() }}
                            </form>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
