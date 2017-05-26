
<h4 class="ui top attached block header">
    Members
</h4>

<table class="bottom attached ui table">
    @foreach($team->users as $user)
        <tr>

            <td>
                <a href="{{ route('user.show', $user) }}">
                    <img src="{{ $user->photo_url }}" class="ui avatar image">
                    {{ $user->name }}
                </a>
            </td>

            <td class="right aligned">
                @can('deleteMember', [ $team, $user ])
                    @component('components.shared.form.delete', [ 
                        'action' => route('team.members.destroy', [$team, $user]) 
                    ])
                        <button type="submit" class="ui tiny compact basic button">
                            @if (Auth::user()->is($user))
                                <i class="trash icon"></i> Leave team
                            @else
                                <i class="trash icon"></i> Kick out
                            @endif
                        </button>
                    @endcomponent
                @endcan
            </td>
            
        </tr>
    @endforeach
</table>
