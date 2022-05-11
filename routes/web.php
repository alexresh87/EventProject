<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

/**
 * Пути для гостей
 */
Route::middleware('guest')->group(function(){

    Route::prefix('auth')
        ->name('auth.')
        ->group(function(){

            /* Страница входа */
            Route::get(
                'login',
                [AuthController::class, 'login']
            )->name('login');

            /* Авторизация */
            Route::post(
                'login',
                [AuthController::class, 'loginSubmit']
            )->name('loginSubmit');

        });

    Route::prefix('orders')->group(function(){

        //Страница с формой для создания заказа
        Route::get('create', [OrderController::class, 'create'])
            ->name('order.create');

        //Добавление заявки в базу
        Route::post('store', [OrderController::class, 'store'])
            ->name('order.store');

    });
});

/**
 * Пути для авторизованных пользователей
 */
Route::middleware('auth')->group(function(){

    //Дашбоард с статистикой заявок по дням
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('auth')
        ->name('auth.')
        ->group(function(){

            //Выход из админки
            Route::get(
                'logout',
                [AuthController::class, 'logout']
            )->name('logout');

    });

    //Пути простотра и изменения заявок
    Route::prefix('orders')->group(function(){

        //Список заявок
        Route::get('get', [OrderController::class, 'index'])
            ->name('order.get');

        //Страница обновления заявки
        Route::get('update/{id}', [OrderController::class, 'update'])
            ->name('order.update');

        //Обновление заявки
        Route::post('update/{id}', [OrderController::class, 'updateSubmit'])
            ->name('order.updateSubmit');

        //Получаем массив количества заявок по дням в заданном месяце и годе
        Route::get('get/{year}/{month}', [OrderController::class, 'getCountByMonth'])
            ->whereNumber('year')
            ->whereNumber('month')
            ->name('order.getCoutByMonth');

    });
});