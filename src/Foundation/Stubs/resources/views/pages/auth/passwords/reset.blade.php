@extends('layouts.app', ['bodyClass' => 'password-reset'])

@section('content')
    @component('components.shared.container.middle')
        <h2 class="ui header">
            Reset Password
        </h2>
        <form class="ui form" role="form" method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}
            <div class="ui stacked segment">
                <input type="hidden" name="token" value="{{ $token }}">

                @component('components.shared.form.field', [ 'name' => 'email' ])
                    <div class="ui left icon input">
                        <i class="user icon"></i>

                        <input 
                            type="email" name="email" 
                            placeholder="E-mail address" 
                            value="{{ old('email') }}" 
                            required autofocus
                        >
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

                <input type="submit" value="Reset Password" class="ui fluid primary submit button">
            </div>
                
            @if (session('status'))
                <div class="ui positive message">
                    {{ session('status') }}
                </div>
            @endif
        </form>
    @endcomponent
@endsection