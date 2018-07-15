<?php
Route::get('/', function () { return redirect()->route('admin.home'); });

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('auth.login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    Route::get('home', 'HomeController@index')->name('admin.home');
    Route::get('deploy/{action}', 'HomeController@deploy')->where('action', 'git-pull|composer-install|artisan-migrate');

    Route::resource('projects', 'ProjectsController');
    Route::post('projects-mass-destroy', 'ProjectsController@massDestroy')->name('projects.mass_destroy');

    Route::group(['middleware' => 'can:users_manage'], function () {
        Route::resource('permissions', 'PermissionsController');
        Route::post('permissions-mass-destroy', ['uses' => 'PermissionsController@massDestroy', 'as' => 'permissions.mass_destroy']);
        Route::resource('roles', 'RolesController');
        Route::post('roles-mass-destroy', ['uses' => 'RolesController@massDestroy', 'as' => 'roles.mass_destroy']);
        Route::resource('users', 'UsersController');
        Route::post('users-mass-destroy', ['uses' => 'UsersController@massDestroy', 'as' => 'users.mass_destroy']);
    });
});