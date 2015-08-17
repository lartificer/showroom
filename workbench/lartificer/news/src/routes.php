<?php

Route::get(trans("news::links.overview"), 'Lartificer\News\Http\Controllers\NewsController@getNewsOverview');
Route::post(trans("news::links.overview"), 'Lartificer\News\Http\Controllers\NewsController@postUpdateNewsEntry');
Route::post(trans("news::links.update") . '/{id}', 'Lartificer\News\Http\Controllers\NewsController@postUpdateNewsEntry');
Route::get(trans("news::links.create"), 'Lartificer\News\Http\Controllers\NewsController@getCreateNewsEntry');
Route::post(trans("news::links.create"), 'Lartificer\News\Http\Controllers\NewsController@postCreateNewsEntry');
Route::get(trans("news::links.delete") . '/{id}', 'Lartificer\News\Http\Controllers\NewsController@deleteNewsEntry');
Route::post(trans("news::links.toggleVisibility"), 'Lartificer\News\Http\Controllers\NewsController@toggleVisibility');

