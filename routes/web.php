<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/

/***
 * 测试 输出 年月日输出
 */
Route::get("/now",function (){
    echo date("y:m:d H:m:s");
}
);

/***
 * 登录控制  路由
 */
Auth::routes();

/***
 * 前台-路由-首页 访问
 */
Route::get('/', 'HomeController@index')->name('home');

/***
 * https://github.com/johnlui/Learn-Laravel-5/issues/18
 * 后台-路由分组 访问
 * 我们要使用路由组来将后台页面置于   “需要登录才能访问”   的中间件下，以保证安全
 *
 *  App\Http\Controllers\Admin\HomeController 的 index 方法。
 * 其中需要登录由 middleware 定义，
   /admin 由 prefix 定义，
 * Admin 由 namespace 定义，
 * HomeController 是实际的类名。
 */
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::get('/', 'HomeController@index');//后台首页
  //  Route::get('article', 'ArticleController@index');//后台 管理_文章列表
    Route::resource('articles', 'ArticleController');//后台 管理_文章(所有articles/下的方法操作【RESTful 操作】)
});
/***
 * RESTful 资源控制器
   资源控制器是 Laravel 内部的一种功能强大的约定，它约定了一系列对某一种资源进行 “增删改查” 操作的路由配置，
 * 让我们不再需要对每一项需要管理的资源都写 N 行重复形式的路由。
 * 中文文档见：https://d.laravel-china.org/docs/5.5/controllers#resource-controllers
 */
Route::resource('photo', 'PhotoController');



Route::get('admin/article','ArticleController@test');