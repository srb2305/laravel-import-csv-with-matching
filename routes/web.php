<?php

/*
|----------------------------------------------------
| Web Routes
| Created By: Saurabh Sahu
| Contact 	: web.saurabhsahu@gmail.com	
|----------------------------------------------------
| 
*/


Auth::routes();
Route::resource( 'product', 'ProductController' );
Route::get( 'category', 'ProductController@category')->name('category');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'ImportController@getImport')->name('import');
Route::post('/import_parse', 'ImportController@parseImport')->name('import_parse');
Route::post('/import_process', 'ImportController@processImport')->name('import_process');
Route::get('/export', 'ProductController@exportProduct')->name('export');

