
<div class="ui card">
    <div class="image">
        <img src="{{ $team->photo_url }}">
    </div>
    <div class="content">
        <form class="ui form" method="POST" action="{{ route('team.update', $team) }}" enctype="multipart/form-data">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}

            @component('components.shared.form.field', [ 'name' => 'avatar' ])
                <input-file name="avatar"></input-file>
            @endcomponent

            <input class="ui fluid button" type="submit" value="Update team photo">
        </form>
    </div>
</div>
