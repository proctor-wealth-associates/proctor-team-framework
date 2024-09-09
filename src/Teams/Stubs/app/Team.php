<?php

namespace App;

use Elegon\Teams\Team as ElegonTeam;

class Team extends ElegonTeam
{
    protected $fillable = [ 'name', 'owner_id' ];

    /**
     * Get the URL of the team's picture.
     *
     * @param  string|null  $value
     * @return string
     */
    public function getPhotoUrlAttribute($value)
    {
        return empty($value) ? url('images/default/team.svg') : url($value);
    }
}
