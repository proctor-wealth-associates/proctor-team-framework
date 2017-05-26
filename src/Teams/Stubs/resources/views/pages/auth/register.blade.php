@extends('layouts.app', ['bodyClass' => 'register'])

@section('content')
    @component('components.shared.container.middle')
    
        @if ($invite)
            @include('components.auth.invite')
        @else
            <h2 class="ui header">Register</h2>
        @endif

        <form class="ui form" role="form" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="ui stacked segments">
                <div class="ui segment">

                    @component('components.shared.form.field', [ 'name' => 'name' ])
                        <div class="ui left icon input">
                            <i class="user icon"></i>

                            <input 
                                type="text" name="name" 
                                placeholder="Name" required autofocus
                            >
                        </div>
                    @endcomponent

                    @component('components.shared.form.field', [ 'name' => 'email' ])
                        <div class="ui left icon input">
                            <i class="mail icon"></i>

                            @if ($invite)
                                <input 
                                    class="ui disabled input" 
                                    type="email" name="email" 
                                    value="{{ $invite->email }}" 
                                    placeholder="E-mail address" 
                                    required readonly
                                >
                            @else
                                <input 
                                    type="email" name="email" 
                                    placeholder="E-mail address" 
                                    required
                                >
                            @endif
                        </div>
                    @endcomponent

                    @component('components.shared.form.field', [ 'name' => 'password' ])
                        <div class="ui left icon input">
                            <i class="lock icon"></i>

                            <input 
                                type="password" name="password" 
                                placeholder="Password" required
                            >
                        </div>
                    @endcomponent

                    @component('components.shared.form.field', [ 'name' => 'password_confirmation' ])
                        <div class="ui left icon input">
                            <i class="lock icon"></i>

                            <input 
                                type="password" name="password_confirmation" 
                                placeholder="Confirm password" required
                            >
                        </div>
                    @endcomponent

                    <input type="submit" value="Register" class="ui fluid primary submit button">
                </div>

                <div class="ui secondary segment">
                    Already have an account? <a href="{{ route('login') }}">Log in</a>
                </div>
            </div>
        </form>
    @endcomponent
@endsection