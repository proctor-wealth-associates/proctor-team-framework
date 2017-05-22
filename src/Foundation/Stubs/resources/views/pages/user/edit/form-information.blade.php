
<form class="ui form" method="POST" action="{{ route('user.update', $user) }}">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    @component('components.shared.form.field', [ 'name' => 'name' ])
        <input type="text" name="name" placeholder="Full Name" value="{{ $user->name }}">
    @endcomponent

    <input class="ui fluid button" type="submit" value="Update">
</form>
