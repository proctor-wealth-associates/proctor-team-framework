
<div class="ui card">
    <div class="image">
    <img src="{{ $team->photo_url }}">
    </div>
    <div class="content">
        <a class="header" href="{{ route('team.show', $team) }}">
            {{ $team->name }}
        </a>
        <div class="meta">
            <span class="date">Created {{ $team->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="extra content">
        <i class="user icon"></i>
        {{ $team->users()->count() }} 
        {{ str_plural('member', $team->users()->count()) }}
    </div>
    @can('manage', $team)
        <a class="ui bottom attached button" href="{{ route('team.edit', $team) }}">
            <i class="edit icon"></i>
            Edit team
        </a>
    @endcan
</div>
