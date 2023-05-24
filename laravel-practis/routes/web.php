<?php

use App\Enums\Category;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserSectionController;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// ビュールート
Route::view('/viewRoute', 'test', ['name' => 'Taylor']);

// 必須パラメータ
// パラメータと依存注入
// {id}が数値の場合にのみ実行される
Route::get('/user/{id}', function (Request $request, string $id) {
    return 'User ' . $id;
});

// オプションパラメータ
// デフォルト値を設定しない場合、$name = null
Route::get('/user/{name?}', function (string $name = 'John') {
    return $name;
});

// ルートにパターン制約をすばやく追加できるヘルパメソッド
// whereNumber...1文字以上の数字であること
// whereAlpha...アルファベットで大文字か小文字の1文字以上であること
//Route::get('/user/{id}/{name}', function (string $id, string $name) {
//    return 'ID '.$id.' '.$name;
//})->whereNumber('id')->whereAlpha('name');

Route::get('/user/{id}/{name}', function (string $id, string $name) {
    return 'ID ' . $id . ' ' . $name;
})->whereAlpha('name');

// withメソッドを使用して個々のデータをビューへ追加
Route::get('/greeting', function () {
    return view('greeting')
        ->with('name', 'Victoria')
        ->with('occupation', 'Astronaut');
});

// 依存注入
Route::get('/dashboard', function (Request $request) {
    return view('dashboard', compact('request'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::name('admin.')->group(function () {
    Route::get('/users', function () {
        // ルートに"admin.users"が名付けられる
        return 'admin.users';
    })->name('users');
});

// 暗黙の結合
// リクエストURIの対応する値と一致するIDを持つモデルインスタンスを自動的に挿入
Route::get('/users/{user}', function (User $user) {
    return $user->email;
});

// 暗黙のEnumバインディング
Route::get('/categories/{category}', function (Category $category) {
    return $category->value;
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 除外ミドルウェア
//    Route::resource('companies', \App\Http\Controllers\CompanyController::class)
//    ->withoutMiddleware('auth')
//        // 見つからないモデルの動作のカスタマイズ
//        ->missing(function (Request $request) {
//            return Redirect::route('companies.index');
//        });; // 追記

    Route::resource('companies', \App\Http\Controllers\CompanyController::class);
    Route::resource('companies.sections', \App\Http\Controllers\SectionController::class)
        ->except(['index']);
    Route::post('companies/{company}/sections/{section}/user_sections', [UserSectionController::class, 'store'])->name('companies.sections.user_sections.store');
});

require __DIR__ . '/auth.php';
