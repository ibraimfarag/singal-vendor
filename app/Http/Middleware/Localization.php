<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Session;
use App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Session::has('language')){
            $language = Language::find(Session::get('language'));
        }else{
            $language = Language::where('is_default',1)->first();
        }
        if(!$language){
            $language = Language::where('is_default',1)->first();
        }
        App::setlocale($language->name);
        return $next($request);
    }
}
