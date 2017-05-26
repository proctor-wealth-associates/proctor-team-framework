<?php

namespace Elegon\Teams;

use Auth;
use Elegon\Foundation\Elegon;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('elegon.teams.invite_table');
    }

    /**
     * Retrieve a invite via its unique token.
     */
    public static function findByToken($token)
    {
        return static::where('token', $token)->first();
    }

    /**
     * Has-One relations with the team model.
     */
    public function team()
    {
        return $this->hasOne(Elegon::teamModel(), 'id', 'team_id' );
    }

    /**
     * Has-One relations with the user model.
     */
    public function user()
    {
        return $this->hasOne(Elegon::userModel(), 'email', 'email');
    }

    /**
     * Has-One relations with the user model.
     */
    public function inviter()
    {
        return $this->hasOne(Elegon::userModel(), 'id', 'user_id' );
    }

    /**
     * Check whether the invitation email matches the given user.
     */
    public function isFor($user)
    {
        return $user->email === $this->email;
    }

    /**
     * Accept the invitation by adding the user to the team.
     */
    public function accept()
    {
        if (Auth::guest() || ! $this->isFor(Auth::user())) {
            throw new \Exception('The authenticated user\'s email does not match the invite email.');
        }

        Auth::user()->attachTeam($this->team);
        Auth::user()->switchTeam($this->team);
        
        $this->delete();
    }

    /**
     * Cancel the invitation by deleting it.
     */
    public function cancel()
    {
        $this->delete();
    }
}
