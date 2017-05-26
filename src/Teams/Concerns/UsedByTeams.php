<?php

namespace Elegon\Teams\Traits;

use Exception;
use Elegon\Foundation\Elegon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait UsedByTeams
{
    /**
     * Boot the global scopes.
     */
    protected static function bootUsedByTeams()
    {
        static::addGlobalScope('team', function (Builder $builder) {
            static::teamGuard();

            $builder->where(
                $builder->getQuery()->from . '.team_id', 
                Auth::user()->currentTeam->getKey()
            );
        });

        static::saving(function (Model $model) {
            static::teamGuard();

            if (! isset($model->team_id)) {
                $model->team_id = Auth::user()->currentTeam->getKey();
            }
        });
    }

    /**
     * Wrapper for removing the 'team' global scope.
     */
    public function scopeAllTeams(Builder $query)
    {
        return $query->withoutGlobalScope('team');
    }

    /**
     * The team associated to that model.
     */
    public function team()
    {
        return $this->belongsTo(Elegon::teamModel());
    }

    /**
     * Throws an exception if there is no authenticated user with a current team.
     */
    protected static function teamGuard()
    {
        if (Auth::guest() || ! Auth::user()->currentTeam) {
            throw new Exception('No authenticated user with a current team.');
        }
    }
}
