@extends('layouts.app', ['bodyClass' => 'login'])

@section('content')
    @component('components.shared.container.middle')

        @if ($invite)
            @include('components.auth.invite')
        @else
            <h2 class="ui header">Log-in to your account</h2>
        @endif

        <form class="ui form" role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="ui stacked segments">
                <div class="ui segment">

                    @component('components.shared.form.field', [ 'name' => 'email' ])
                        <div class="ui left icon input">
                            <i class="user icon"></i>

                            @if ($invite)
                                <input 
                                    class="ui disabled input" 
                                    type="email" name="email" 
                                    placeholder="E-mail address" 
                                    value="{{ $invite->email }}" 
                                    required readonly
                                >
                            @else
                                <input 
                                    type="email" name="email" 
                                    placeholder="E-mail address" 
                                    value="{{ old('email') }}" 
                                    required autofocus
                                >
                            @endif
                        </div>
                    @endcomponent

                    @component('components.shared.form.field', [ 'name' => 'password' ])
                        <div class="ui left icon input">
                            <i class="lock icon"></i>

                            <input 
                                type="password" name="password"
                                placeholder="Password"
                                required
                            >
                        </div>
                    @endcomponent

                    <div class="field" style="text-align: left;">
                        <div class="ui checkbox">
                            <input 
                                type="checkbox" name="remember"
                                id="remember" tabindex="0" class="hidden" 
                                {{ old('remember') ? 'checked' : '' }}
                            >
                            <label for="remember">Remember me</label>
                        </div>
                    </div>

                    <input type="submit" value="Login" class="ui fluid primary submit button">
                </div>

                <div class="ui secondary segment">
                    <div class="ui list">
                        <div class="item">
                            Don't have an account yet? <a href="{{ route('register') }}">Sign Up</a>
                        </div>
                        <div class="item">
                            <a href="{{ route('password.request') }}">I forgot my password</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endcomponent
@endsection
