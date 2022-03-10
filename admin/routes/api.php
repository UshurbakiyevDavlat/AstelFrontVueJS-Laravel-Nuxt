<?php

use Illuminate\Support\Facades\Route;
 
Route::group([
    'prefix' => 'page',
], function() {
    Route::get('/', 'PageController@index');
    Route::get('{page}/{slug?}', 'PageController@process')->where('slug', '(.*)');
    Route::post('{page}/{slug?}', 'PageController@storeTranslation')->where('slug', '(.*)');
});

Route::get('post', 'PostController@paginate')->name('posts');
Route::get('project', 'ProjectController@paginate')->name('projects');

Route::post('callback', 'FormController@callback');
Route::post('vacancy/{vacancy}', 'FormController@vacancy');