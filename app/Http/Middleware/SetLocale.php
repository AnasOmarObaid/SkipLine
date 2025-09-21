<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class SetLocale
{
    public function handle($request, Closure $next)
    {

        $supported = array_keys(Config::get('locales.supported'));
        $locale = $request->segment(1);

        // If found in URL
        if (in_array($locale, $supported)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
            Cookie::queue('locale', $locale, 60 * 24 * 30); // 30 days

        } else {
            // If not found in URL, check session or cookie
            $locale = Session::get('locale') ?? Cookie::get('locale') ?? config('locales.default');
            return redirect("/$locale" . $request->getRequestUri());
        }

        return $next($request);
    }
}
