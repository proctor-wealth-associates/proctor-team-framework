<?php

namespace Elegon\Foundation;

use Elegon\Teams\Concerns\CanJoinTeams;

class Elegon
{
    const PACKAGES = [
        'Foundation',
        'Impersonation',
        'Teams',
    ];

    public static $userModel;

    public static $teamModel;

    public static $inviteModel;

    public static $routePrefix = '';

    public static $disabledPackageRoutes = [];

    // Users and teams

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
        return in_array(CanJoinTeams::class, class_uses_recursive(static::userModel()));
    }

    public static function teamModel()
    {
        return static::$teamModel;
    }

    public static function team()
    {
        return new static::$teamModel;
    }

    public static function useInviteModel($inviteModel)
    {
        static::$inviteModel = $inviteModel;
    }

    public static function inviteModel()
    {
        return static::$inviteModel;
    }

    public static function invite()
    {
        return new static::$inviteModel;
    }

    // Packages

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

    // Routes
    
    public static function setRoutePrefix($prefix)
    {
        static::$routePrefix = $prefix;
    }
    
    public static function routePrefix()
    {
        return static::$routePrefix;
    }

    public static function disableRoutesFor($packageName)
    {
        static::$disabledPackageRoutes[] = $packageName;
    }

    public static function routesDisabledFor($packageName)
    {
        return in_array($packageName, static::$disabledPackageRoutes);
    }
}
