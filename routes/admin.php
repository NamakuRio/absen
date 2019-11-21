<?php

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
|
| You can update this public route
|
*/

Route::get('/', 'DashboardController@index')->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| App Routes
|--------------------------------------------------------------------------
|
| All route app in this
|
*/

Route::group(['prefix' => 'employees'], function() {
    Route::get('/', 'EmployeeController@index')->name('admin.employee');
    Route::get('/data', 'EmployeeController@data')->name('admin.employee.data');

    Route::post('/', 'EmployeeController@store')->name('admin.employee.store');
    Route::post('/update', 'EmployeeController@edit')->name('admin.employee.edit');

    Route::put('/update', 'EmployeeController@update')->name('admin.employee.update');

    Route::delete('/', 'EmployeeController@destroy')->name('admin.employee.destroy');
});

Route::group(['prefix' => 'presence'], function() {
    Route::get('/', 'PresenceController@index')->name('admin.presence');
    Route::get('/data', 'PresenceController@data')->name('admin.presence.data');

    Route::group(['prefix' => 'type'], function(){
        Route::get('/', 'PresenceTypeController@index')->name('admin.presence_type');
        Route::get('/data', 'PresenceTypeController@data')->name('admin.presence_type.data');

        Route::post('/', 'PresenceTypeController@store')->name('admin.presence_type.store');
        Route::post('/update', 'PresenceTypeController@edit')->name('admin.presence_type.edit');

        Route::put('/update', 'PresenceTypeController@update')->name('admin.presence_type.update');

        Route::delete('/', 'PresenceTypeController@destroy')->name('admin.presence_type.destroy');
    });

    Route::get('/{presence}', 'PresenceController@show')->name('admin.presence.show');
    Route::get('/data/{presence}', 'PresenceDetailController@data')->name('admin.presence_detail.data');
});

/*
|--------------------------------------------------------------------------
| Core Routes
|--------------------------------------------------------------------------
|
| Please don't change this route
|
*/

Route::group(['prefix' => 'account'], function() {
    Route::get('/', 'AccountController@index')->name('admin.account');

    Route::put('/', 'AccountController@update')->name('admin.account.update')->middleware('ajax');
});

Route::group(['prefix' => 'users'], function() {
    Route::get('/', 'UserController@index')->name('admin.user');
    Route::get('/data', 'UserController@data')->name('admin.user.data');

    Route::post('/', 'UserController@store')->name('admin.user.store');
    Route::post('/update', 'UserController@edit')->name('admin.user.edit');
    Route::post('/manage', 'UserController@getManage')->name('admin.user.manage.get');

    Route::put('/update', 'UserController@update')->name('admin.user.update');
    Route::put('/manage', 'UserController@manage')->name('admin.user.manage');

    Route::delete('/', 'UserController@destroy')->name('admin.user.destroy');
});

Route::group(['prefix' => 'roles'], function() {
    Route::get('/', 'RoleController@index')->name('admin.role');
    Route::get('/data/select2', 'RoleController@list')->name('admin.role.data.select2');
    Route::get('/data', 'RoleController@data')->name('admin.role.data');

    Route::post('/', 'RoleController@store')->name('admin.role.store');
    Route::post('/update', 'RoleController@edit')->name('admin.role.edit');
    Route::post('/manage', 'RoleController@getManage')->name('admin.role.manage.get');
    Route::post('/default-user', 'RoleController@setDefault')->name('admin.role.default');

    Route::put('/update', 'RoleController@update')->name('admin.role.update');
    Route::put('/manage', 'RoleController@manage')->name('admin.role.manage');

    Route::delete('/', 'RoleController@destroy')->name('admin.role.destroy');
});

Route::group(['prefix' => 'permissions'], function() {
    Route::get('/', 'PermissionController@index')->name('admin.permission');
    Route::get('/data', 'PermissionController@data')->name('admin.permission.data');

    Route::post('/', 'PermissionController@store')->name('admin.permission.store');
    Route::post('/update', 'PermissionController@edit')->name('admin.permission.edit');

    Route::put('/update', 'PermissionController@update')->name('admin.permission.update');

    Route::delete('/', 'PermissionController@destroy')->name('admin.permission.destroy');
});

Route::group(['prefix' => 'setting'], function() {
    Route::get('/', 'SettingGroupController@index')->name('admin.setting.group');
    Route::get('/{setting_group}', 'SettingGroupController@show')->name('admin.setting.show');
});
