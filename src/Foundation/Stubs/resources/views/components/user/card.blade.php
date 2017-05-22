
<div class="ui user fluid card">
    <div class="content">
        <div class="header">{{ $user->name }}</div>
        <div class="meta">
            <span class="date">Registered {{ $user->created_at->diffForHumans() }}</span>
        </div>
        <div class="description">
            Well, the Force is what gives a Jedi his power. It's an energy field created by all living things. It surrounds us and penetrates us. It binds the galaxy together. Now, let's see if we can't figure out what you are, my little friend. And where you come from. I saw part of the message he was... I seem to have found it.
        </div>
    </div>
    @can('manage', $user)
        <a class="ui bottom attached button" href="{{ route('user.edit', $user) }}">
            <i class="edit icon"></i>
            Edit profile
        </a>
    @endcan
    <div class="profile-picture">
        <img class="ui circular image" src="{{ $user->photo_url }}">
    </div>
</div>
