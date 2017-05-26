<?php

namespace Elegon\Teams;

use Auth;
use Elegon;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = [ 'name', 'owner_id' ];

    /**
     * One-to-Many relation with the invite model.
     */
    public function invites()
    {
        return $this->hasMany(Elegon::inviteModel(), 'team_id', 'id');
    }
    
    /**
     * Many-to-Many relations with the user model.
     */
    public function users()
    {
        return $this->belongsToMany(Elegon::userModel(), config('elegon.teams.team_user_table'), 'team_id', 'user_id')->withTimestamps();
    }

    /**
     * Has-One relation with the user model.
     * This indicates the owner of the team.
     */
    public function owner()
    {
        return $this->hasOne(Elegon::userModel(), Elegon::user()->getKeyName(), "owner_id");
    }

    /**
     * Helper function to determine if a user is part of this team.
     */
    public function hasUser(Model $user)
    {
        return $this->users()->where($user->getKeyName(), $user->getKey())->exists();
    }

    /**
     * Check if the authenticated user has this team as a current team.
     */
    public function isCurrent()
    {
        return $this->isCurrentFor(Auth::user());
    }

    /**
     * Check if the given user has this team as a current team.
     */
    public function isCurrentFor(Model $user)
    {
        return $user->isCurrentTeam($this);
    }

    /**
     * Check whether an invite has already been sent to the given email address.
     */
    public function hasPendingInvite($email)
    {
        return $this->invites()->where('email', $email)->exists();
    }

    /**
     * Invite a user to the team.
     */
    public function invite($invitee)
    {
        $invite = Elegon::invite()->forceCreate([
            'user_id' => Auth::user()->getKey(),
            'team_id' => $this->getKey(),
            'type'    => 'invite',
            'email'   => $this->getInviteeEmail($invitee),
            'token'   => md5(uniqid(microtime())),
        ]);

        return $invite;
    }

    /**
     * Get the email either from a given string or from a given user model.
     */
    protected function getInviteeEmail($invitee)
    {
        if (is_object($invitee) && isset($invitee->email)) {
            return $invitee->email;
        } else {
            return $invitee;
        }
    }
}
