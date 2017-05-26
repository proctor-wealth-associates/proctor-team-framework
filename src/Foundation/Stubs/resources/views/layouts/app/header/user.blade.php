
<div class="ui simple dropdown item">

    {{-- Profile button --}}
    <img class="ui avatar image" src="{{ Auth::user()->photo_url }}">
    {{ Auth::user()->name }}
    <i class="dropdown icon"></i>

    {{-- Dropdown menu --}}
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
            <form method="POST"  id="logout-form"  style="display: none;" action="{{ route('logout') }}">
                {{ csrf_field() }}
            </form>
        </a>

    </div>
</div>
