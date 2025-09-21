<?php

if (!function_exists('localized_route')) {
    function localized_route($name, $parameters = [], $absolute = true)
    {
        $locale = app()->getLocale();
        return route($name, array_merge(['locale' => $locale], $parameters), $absolute);
    }
}
