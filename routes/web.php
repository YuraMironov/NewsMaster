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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('sources', 'SourceController');
Route::resource('articles', 'ArticleController');
Route::resource('keywords', 'KeywordController');

Route::get('keywords/popular/{count}', 'KeywordController@popular')->where('count', '[0-9]+');;
Route::get('keywords/reports/popular', 'ReportController@keywordNewsCountReportByDayAction');
Route::get('keywords/reports/{id}', 'ReportController@keywordReportAction')->where('id', '[0-9]+');


