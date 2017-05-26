
<table class="ui bottom attached table">
    <tbody>
        @foreach($teams as $team)
            <tr
                @if ($team->isCurrent())
                    class="positive"
                @endif
            >
                <td>
                    <a 
                        class="ui image{{ $team->isCurrent() ? ' teal' : '' }} label" 
                        href="{{ route('team.show', $team) }}"
                    >
                        <img src="{{ $team->photo_url }}">
                        {{ $team->name }}
                    </a>
                </td>

                <td>
                    @if(Auth::user()->isOwnerOfTeam($team))
                        <span class="ui tiny label">Owner</span>
                    @endif
                </td>

                <td class="right aligned">
                    @unless(Auth::user()->isCurrentTeam($team))
                        <a href="{{ route('team.switch', $team) }}" class="ui tiny compact basic button">
                            <i class="sign in icon"></i> Switch
                        </a>
                    @endunless

                    @can('manage', $team)
                        <a href="{{ route('team.edit', $team) }}" class="ui tiny compact basic button">
                            <i class="edit icon"></i> Edit
                        </a>

                        @component('components.shared.form.delete', [ 
                            'action' => route('team.destroy', $team) 
                        ])
                            <button type="submit" class="ui tiny compact basic button">
                                <i class="trash icon"></i> Delete
                            </button>
                        @endcomponent
                    @endcan
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
