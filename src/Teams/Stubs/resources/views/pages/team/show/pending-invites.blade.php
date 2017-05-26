
<h4 class="ui top attached block header">
    Pending invitations
</h4>

@if ($team->invites()->exists())

    <table class="bottom attached ui table">
        @foreach($team->invites as $invite)
            <tr>

                <td>
                    {{ $invite->email }}
                </td>

                <td class="right aligned">
                    <a href="{{ route('team.invite.resend', $invite) }}"  class="ui tiny compact basic button">
                        <i class="mail icon"></i> Resend
                    </a>
                    @can('delete', $invite)
                        @component('components.shared.form.delete', [ 
                            'action' => route('team.invite.cancel', $invite) 
                        ])
                            <button type="submit" class="ui tiny compact basic button">
                                <i class="cancel icon"></i> Cancel
                            </button>
                        @endcomponent
                    @endcan
                </td>

            </tr>
        @endforeach
    </table>

@else

    <div class="ui bottom attached segment">
        <em>No pending invitations</em>
    </div>

@endif
