
@if ($invite)
    <div class="ui success message">
        <div class="ui items">
            <div class="item">

                <div class="ui tiny rounded image">
                    <img src="{{ $invite->team->photo_url }}">
                </div>

                <div class="middle aligned content" style="text-align: left;">
                    <div class="header">
                        {{ $invite->team->name }}
                    </div>

                    <div class="description">
                        <p>You have been invited to join {{ $invite->team->name }}.</p>
                        <a href="{{ route('team.invite.ignore') }}">
                            Ignore this invitation
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endif
