<?php

namespace Elegon\Foundation;

class Elegon
{
    public static $userModel = null;

    public static $teamModel = null;

    public static function useUserModel($userModel)
    {
        static::$userModel = $userModel;
    }

    public static function userModel()
    {
        return static::$userModel;
    }

    public static function user()
    {
        return new static::$userModel;
    }

    public static function useTeamModel($teamModel)
    {
        static::$teamModel = $teamModel;
    }

    public static function usesTeams()
    {
        // return in_array(CanJoinTeams::class, class_uses_recursive(static::userModel()));
    }

    public static function teamModel()
    {
        return static::$teamModel;
    }

    public static function team()
    {
        return new static::$teamModel;
    }

    public static function hasPackage($elegonServiceProvider, $elegonPackage = null)
    {
        $elegonPackage = $elegonPackage ?: $elegonServiceProvider;
        $class = "Elegon\\{$elegonPackage}\\{$elegonServiceProvider}ServiceProvider";

        return static::hasServiceProvider($class);
    }

    public static function hasServiceProvider($class)
    {
        return in_array($class, config('app.providers'));
    }
}
