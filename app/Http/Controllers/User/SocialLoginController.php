<?php

namespace App\Http\Controllers\User;

use App\{
    Models\User,
    Models\Setting,
    Models\Notification,
    Helpers\EmailHelper,
    Models\SocialProvider,
    Http\Controllers\Controller
};

use Auth;
use Config;
use Socialite;
use Illuminate\Http\Request;

class SocialLoginController extends Controller
{
    public function __construct()
    {
      $link = Setting::first();

      Config::set('services.google.client_id', $link->google_client_id);
      Config::set('services.google.client_secret', $link->google_client_secret);
      Config::set('services.google.redirect', url('/auth/google/callback'));

      Config::set('services.twitter.client_id', $link->twitter_client_id);
      Config::set('services.twitter.client_secret', $link->twitter_client_secret);
      Config::set('services.twitter.redirect', url('/auth/twitter/callback'));

      Config::set('services.facebook.client_id', $link->facebook_client_id);
      Config::set('services.facebook.client_secret', $link->google_client_secret);
      Config::set('services.facebook.redirect', preg_replace("/^http:/i", "https:", url('/auth/facebook/callback')));
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try
        {
            $socialUser = Socialite::driver($provider)->user();
        }
        catch(\Exception $e)
        {
            return redirect('/');
        }
        //check if we have logged provider
        $socialProvider = SocialProvider::where('provider_id',$socialUser->getId())->first();
        if(!$socialProvider)
        {

            if(User::where('email',$socialUser->email)->exists())
            {
                $auser = User::where('email',$socialUser->email)->first();
                Auth::login($auser);
                return redirect()->route('user.dashboard');
            }
            //create a new user and provider

            $name = $this->split_name($socialUser->name);

            $user = new User;
            $user->email = $socialUser->email;
            $user->first_name = $name[0];
            $user->last_name = $name[1];
            $user->save();

            $user->socialProviders()->create(
                ['provider_id' => $socialUser->getId(), 'provider' => $provider]
            );
            Notification::create([
                'user_id' => $user->id
            ]);

            $emailData = [
                'to' => $user->email,
                'type' => "Registration",
                'user_name' => $user->displayName(),
                'order_cost' => '',
                'transaction_number' => '',
                'site_title' => Setting::first()->title,
            ];

            $email = new EmailHelper();

        }
        else
        {


            if(User::where('email',$socialUser->email)->exists())
            {
                $auser = User::where('email',$socialUser->email)->first();
                Auth::guard('web')->login($auser);
                return redirect()->route('user-dashboard');
            }

            $user = $socialProvider->user;
        }

        Auth::login($user);
        return redirect()->route('user.dashboard');

    }

    function split_name($name) {
        $name = trim($name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );
        return array($first_name, $last_name);
    }

}
