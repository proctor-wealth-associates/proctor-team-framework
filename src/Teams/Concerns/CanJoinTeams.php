<?php

namespace Elegon\Teams\Concerns;

use Elegon;
use Elegon\Teams\Events\UserLeftTeam;
use Elegon\Teams\Events\UserJoinedTeam;
use Illuminate\Database\Eloquent\Model;

trait CanJoinTeams
{
    /**
     * Many-to-Many relations with the user model.
     */
    public function teams()
    {
        return $this->belongsToMany(
            Elegon::teamModel(), 
            config('elegon.teams.team_user_table'), 
            'user_id', 'team_id'
        )->withTimestamps();
    }

    /**
     * Has-one relation with the current selected team model.
     */
    public function currentTeam()
    {
        return $this->hasOne(Elegon::teamModel(), 'id', 'current_team_id');
    }

    /**
     * Returns all teams owned by the user.
     */
    public function ownedTeams()
    {
        return $this->teams()->where('owner_id', $this->getKey());
    }

    /**
     * One-to-Many relation with the invite model.
     */
    public function invites()
    {
        return $this->hasMany(config('teamwork.invite_model'), 'email', 'email');
    }

    /**
     * Add delete event listener to unsync teams when softDeletes are not used.
     */
    public static function bootCanJoinTeams()
    {
        static::deleting(function (Model $user) {
            if (! method_exists(Elegon::userModel(), 'bootSoftDeletes')) {
                $user->teams()->sync([]);
            }
            return true;
        });
    }

    /**
     * Returns true if the user owns at least one team.
     */
    public function isOwner()
    {
        return $this->teams()->where('owner_id', $this->getKey())->exists();
    }

    /**
     * Returns if the user owns the given team.
     */
    public function isOwnerOfTeam($team)
    {
        return $this->teams()
            ->where('owner_id', $this->getKey())
            ->where('team_id', $team->getKey())
            ->exists();
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     */
    public function attachTeam($team, $pivotData = [])
    {
        if ($this->teams->contains($team)) {
            return;
        }

        $this->teams()->attach($team, $pivotData);

        if (! $this->current_team_id) {
            $this->switchTeam($team);
        }

        event(new UserJoinedTeam($this, $team));
        $this->reload('teams');

        return $this;
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     */
    public function detachTeam($team)
    {
        $this->teams()->detach($team->getKey());

        event(new UserLeftTeam($this, $team));
        $this->reload('teams');
        
        if (! $this->teams()->exists() || $this->current_team_id === $team->getKey()) {
            $this->switchTeam(null);
        }

        return $this;
    }

    /**
     * Attach multiple teams to a user.
     */
    public function attachTeams($teams)
    {
        foreach ($teams as $team) {
            $this->attachTeam($team);
        }

        return $this;
    }

    /**
     * Detach multiple teams from a user.
     */
    public function detachTeams($teams)
    {
        foreach ($teams as $team) {
            $this->detachTeam($team);
        }

        return $this;
    }

    /**
     * Switch the current team of the user.
     */
    public function switchTeam($team = null)
    {
        $this->current_team_id = $team ? $team->getKey() : null;
        $this->save();
        $this->reload('currentTeam');
        
        return $this;
    }

    /**
     * Check that the given team is the current team.
     */
    public function isCurrentTeam($team)
    {
        return ! is_null($this->currentTeam) 
            && $this->currentTeam->getKey() === $team->getKey();
    }

    /**
     * Check that both users are part of a common team.
     */
    public function hasTeamInCommonWith($user)
    {
        return $this->teams->contains(function($team) use ($user) {
            return $team->hasUser($user);
        });
    }

    /**
     * Offer some quick team suggestions to help the user to switch teams.
     */
    public function teamSuggestions()
    {
        return $this->teams()
            ->where(Elegon::team()->getKeyName(), '!=', $this->current_team_id)
            ->take(3)->get();
    }

    /**
     * Reload the relation if it has already been loaded.
     */
    private function reload($relation)
    {
        if ($this->relationLoaded($relation)) {
            $this->load($relation);
        }
    }
}
