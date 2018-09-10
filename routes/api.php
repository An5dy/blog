<?php


/*
|--------------------------------------------------------------------------
| 后台 API Routes
|--------------------------------------------------------------------------
*/

Route::post('admin/login', 'Api\LoginController@login');// 登录
Route::get('admin/logout', 'Api\LoginController@logout')->middleware('auth:api');// 退出登录
Route::post('admin/reset', 'Api\LoginController@update')->middleware('auth:api');// 账号密码修改
Route::get('admin/tokens/refresh', 'Api\LoginController@refresh');// 刷新 token
Route::apiResource('admin/categories', 'Api\CategoryController')->middleware('auth:api');// 分类
Route::apiResource('admin/abouts', 'Api\AboutController', [
    'only' => ['index', 'store', 'update'],
])->middleware('auth:api');// 关于
Route::apiResource('admin/articles', 'Api\ArticleController')->middleware('auth:api');// 文章
Route::apiResource('admin/tags', 'Api\TagController', [
    'only' => ['destroy'],
])->middleware('auth:api');// 标签
Route::post('admin/images', 'Api\ImageController')->middleware('auth:api');// 图片上传

/*
|--------------------------------------------------------------------------
| 前台 API Routes
|--------------------------------------------------------------------------
*/

Route::apiResource('abouts', 'Api\AboutController', [
    'only' => ['index'],
]);// 关于
Route::apiResource('articles', 'Api\ArticleController', [
    'only' => ['index', 'show'],
]);// 文章
Route::get('/archives', 'Api\ArticleController@archive');// 归档

