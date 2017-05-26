
@if (Auth::user()->teams()->exists())
    
    @if (Auth::user()->currentTeam)
        <div 
            class="ui simple dropdown item" 
            @click="window.location = '{{ route('team.show', Auth::user()->currentTeam) }}'"
        >
    @else
        <div class="ui simple dropdown item">
    @endif

        {{-- Current team button --}}
        @if (Auth::user()->currentTeam)
            {{ Auth::user()->currentTeam->name }}
        @else
            No current team
        @endif

        <i class="dropdown icon"></i>

        {{-- Dropdown menu --}}
        <div class="menu">

            {{-- Suggestions for switching team --}}
            @forelse (Auth::user()->teamSuggestions() as $team)
                <a class="item" href="{{ route('team.switch', $team) }}">
                    {{ $team->name }}
                </a>

            {{-- No other teams to suggest --}}
            @empty
                <a class="item" style="text-align: center;" href="{{ route('team.create') }}">
                    Create
                </a>
            @endforelse
            
            <div class="divider"></div>

            <a class="item" style="text-align: center;" href="{{ route('team.index') }}">
                See all
            </a>

        </div>
    </div>

@else

    {{-- User has no team --}}
    <a class="item" href="{{ route('team.create') }}">
        <i class="plus icon"></i> Create a team
    </a>

@endif
