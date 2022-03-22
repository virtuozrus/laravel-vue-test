<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Post;
use App\Settings;
use App\User;
use App\UserSocial;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Two\FacebookProvider;
use Mockery\Exception;
use Socialite;
use SocialiteProviders\VKontakte\VKontakteExtendSocialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/bitva';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function facebook()
    {
        Session::put('user_id', null);
        Auth::logout();

        return Socialite::driver('facebook')->fields([
            'name', 'first_name', 'last_name', 'email', 'gender', 'avatar'
        ])->scopes([
            'email'
        ])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function facebookCallback()
    {
        try {
            /** @var FacebookProvider $Facebook */
            $Facebook = Socialite::driver('facebook')->fields([
                'first_name', 'last_name', 'email', 'gender'
            ]);

            if ($result = $this->registerUser($Facebook->user(), 'facebook')) {
                return $result;
            }

            return redirect('/bitva/upload');
        } catch (\Exception $e) {
            return redirect('/bitva');
        }
    }

    /**
     * @return mixed
     */
    public function vk()
    {
        Session::put('user_id', null);
        Auth::logout();

        return Socialite::with('vkontakte')->redirect();
    }

    /**
     *
     */
    public function vkCallback()
    {
        try {
            /** @var VKontakteExtendSocialite $Facebook */
            $VK = Socialite::driver('vkontakte')->fields([
                'first_name', 'last_name', 'email', 'gender'
            ]);

            if ($result = $this->registerUser($VK->user(), 'vk')) {
                return $result;
            }

            return redirect('/bitva/upload');
        } catch (\Exception $e) {
            return redirect('/bitva');
        }
    }

    /**
     * @param $user
     * @param $type
     * @return RedirectResponse|Redirector|void
     */
    protected function registerUser($user, $type)
    {
        if ($user) {
            $ExistUser = UserSocial::where([['social', '=', $type], ['key', '=', $user->id]])->first();

            if (!$ExistUser) {
                $NewUser = new User;
                $NewUser->name = $user->name;

                if (!$user->name && isset($user->user['first_name'])) {
                    $NewUser->name = $user->user['first_name'] . ' ' . $user->user['last_name'];
                }

                if ($user->email) {
                    $NewUser->email = $user->email;
                }

                if ($user->avatar) {
                    $NewUser->avatar = $user->avatar;
                }

                $NewUser->save();

                $ExistUser = new UserSocial;
                $ExistUser->user_id = $NewUser->id;
                $ExistUser->social = $type;
                $ExistUser->key = $user->id;
                $ExistUser->token = $user->token;
                $ExistUser->save();
            }

            Session::put('user_id', $ExistUser->user->id);
            Auth::login($ExistUser->user, true);
        }

        $Settings = Settings::where([['key', '=', 'step']])->first();

        if (!!$Settings && $Settings->value == 'gallery') {
            return redirect('/bitva');
        }

        if (!!$ExistUser) {
            $posts = Post::where([['user_id', '=', $ExistUser->user_id], ['status', '!=', 'deleted']])->count();

            if ($posts) {
                return redirect('/bitva');
            }
        }

        return null;
    }
}
