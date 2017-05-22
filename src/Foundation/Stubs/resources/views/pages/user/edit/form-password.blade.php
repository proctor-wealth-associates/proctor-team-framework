
<form class="ui form" method="POST" action="{{ route('user.update', $user) }}">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    @component('components.shared.form.field', [ 'name' => 'password' ])
        <input type="password" name="password" placeholder="Password">
    @endcomponent

    @component('components.shared.form.field', [ 'name' => 'password_confirmation' ])
        <input type="password" name="password_confirmation" placeholder="Confirm password">
    @endcomponent

    <input class="ui fluid button" type="submit" value="Change password">
</form>
