
<form class="ui form" method="POST" action="{{ route('user.update', $user) }}" enctype="multipart/form-data" style="margin-top: 1em;">
    {{ method_field('PATCH') }}
    {{ csrf_field() }}

    @component('components.shared.form.field', [ 'name' => 'avatar' ])
        <input-file name="avatar"></input-file>
    @endcomponent

    <input class="ui fluid button" type="submit" value="Update profile picture">
</form>
