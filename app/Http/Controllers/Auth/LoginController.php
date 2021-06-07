<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    protected $redirectTo = 'project';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticated(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // if success login
            $id = \auth()->user()->pegawai->id_pegawai;
            $attendance = Attendance::query()->where('id_pegawai', $id)->whereDate('jam_masuk', date('Y-m-d'))->first();
            if (!$attendance) {
                Attendance::query()->create([
                    'id_pegawai' => $id,
                    'jam_masuk' => date('Y-m-d H:i:s')
                ]);
            }
            return redirect('project');


        }
        // if failed login
        return redirect('login');
    }

    public function logout(Request $request)
    {
        $id = \auth()->user()->pegawai->id_pegawai;
        $attendance = Attendance::query()->where('id_pegawai', $id)->whereDate('jam_masuk', date('Y-m-d'))
            ->first();
        if ($attendance) {
            $attendance->jam_keluar = date('Y-m-d H:i:s');
            $attendance->save();
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
