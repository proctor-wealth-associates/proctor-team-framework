<?php

namespace Elegon\Foundation\Concerns;

use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests as BaseAuthorizesRequests;

trait AuthorizesRequests
{
    use BaseAuthorizesRequests;

    /**
     * Authorize a resource's actions based on its policy.
     *
     * @param  string  $model
     * @param  string|null  $parameter
     * @param  array  $options
     * @return void
     */
    public function authorizePolicy($model, $additionalAbilities = [], $parameter = null, array $options = [])
    {
        $abilityMap = array_merge($this->abilityMap(), $additionalAbilities);
        $parameter = $parameter ?: lcfirst(class_basename($model));
        $policy = app(Gate::class)->getPolicyFor($model);
        $middleware = [];

        foreach ($abilityMap as $method => $abilities) {

            // Make [ 'action' ] equivalent to [ 'action' => 'action' ].
            if (is_numeric($method)) {
                $method = $abilities;
            }

            // Ignore if the method does not exist in the controller.
            if (! method_exists($this, $method)) {
                continue;
            }

            // Ignore if the ability does not exist in the policy. Take the first one otherwise.
            if (! ($ability = $this->getFirstAvailableAbility($abilities, $policy))) {
                continue;
            }

            // Add a middleware to link the ability with the method.
            $modelName = in_array($method, $this->resourceMethodsWithoutModels()) ? $model : $parameter;
            $middleware["can:{$ability},{$modelName}"][] = $method;
        }

        // Register all middleware.
        foreach ($middleware as $middlewareName => $methods) {
            $this->middleware($middlewareName, $options)->only($methods);
        }
    }

    /**
     * Return the first available ability in the given model's policy.
     *
     * @param string $abilities A pipe delimited list of abilities. 
     * @param Policy $policy The policy associated with the model.
     * @return string|null The ability or null of none was found.
     */
    protected function getFirstAvailableAbility($abilities, $policy)
    {
        foreach (explode('|', $abilities) as $ability) {
            if (method_exists($policy, camel_case($ability))) {
                return $ability;
            }
        }

        return null;
    }

    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    protected function abilityMap()
    {
        return [
            'show' => 'view',
            'index' => 'viewAll',
            'create' => 'create',
            'store' => 'create',
            'update' => 'update|manage',
            'edit' => 'update|manage',
            'destroy' => 'delete|manage',
        ];
    }
}
