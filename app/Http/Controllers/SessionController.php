<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class SessionController extends Controller
{
    function index(){

        return view('sesi/index');

    }

    function login(Request $request){

    $request->validate([
      'email' => 'required',
      'password' => 'required'
    ], [
      'email.required' => 'Email wajib diisi',
      'password.required' => 'password wajib diisi'
    ]);

    $infologin = [
       'email' => $request->email,
       'password' => $request->password
    ];

    if (Auth::attempt($infologin)){
        //return 'sukses';
       return redirect('siswa')->with('success', Auth::user()->name. ' Berhasil Login');
    }
    else {
        //return 'gagal';
        return redirect('sesi')->withErrors('Username dan password tidak valid');
        }
    
    }


    function logout() {

    Auth::logout();
    return redirect('sesi')->with('success', 'berhasil logout');

    }


    function register() {

         return view('sesi/register');

    }


    function create(Request $request) {

      $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6'
      ], [
        'name.required' => 'Nama wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Silakan masukan email yang valid',
        'email.unique' => 'Email sudah pernah digunakan, silakan pilih email yang lain',
        'password.required' => 'password wajib diisi',
        'password.min' => 'Password minimal 6 karakter'
      ]);

      $data = [
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password) 
      ];
      user::create($data);


      $infologin = [
         'email' => $request->email,
         'password' => $request->password
      ];
  
      if (Auth::attempt($infologin)){
          //return 'sukses';
         return redirect('siswa')->with('success', Auth::user()->name. ' Berhasil Login');
      }
      else 
      {
          //return 'gagal';
          return redirect('sesi')->withErrors('Username dan password tidak valid');
      }

    }

public function lupaPassword()
{
    return view('sesi.gantipassword');
}


public function kirimResetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('success', __($status))
        : back()->withErrors(['email' => __($status)]);
}

public function formResetPassword($token)
{
    return view('sesi.reset-password', [
        'token' => $token
    ]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect('/sesi')->with('success', 'Password berhasil direset')
        : back()->withErrors(['email' => [__($status)]]);
}

}
