<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    
    /**
     * Выводим страницу авторизации
     */
    public function login(){
        return view('auth.login');
    }

    /**
     * Авторизация менеджера
     */
    public function loginSubmit(AuthRequest $request){

        //Проверка логина и пароля
        if (! Auth::attempt($request->only('email', 'password'), $request->has('remember')))
		{
            return redirect()
                ->route('auth.login')
                ->with('error_message','Неправильный логин или пароль');
		}
        
        $request
            ->session()
            ->regenerate();

        return redirect()->intended('dashboard');
    }

    /**
     * Выход из личного кабинета менеджера
     */
    public function logout(Request $request){
        Auth::logout();

        $request
            ->session()
            ->invalidate();

        $request
            ->session()
            ->regenerateToken();

        return redirect('/');
    }
}
