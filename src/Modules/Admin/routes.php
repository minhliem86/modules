<?php
Route::group(['prefix' => 'admin', 'namespace' => 'App\Modules\Admin\Controllers'], function(){
    // Authentication Routes...
    Route::group(['middleware'=>['web']], function(){
        Route::get('login',['as' => 'admin.login.get', 'uses' => 'Auth\AuthController@showLoginForm']);
        Route::post('login',['as' => 'admin.login.post', 'uses' => 'Auth\AuthController@login']);
        Route::get('logout', ['as' => 'admin.logout.post', 'uses' => 'Auth\AuthController@logout']);

        // Registration Routes...
        Route::get('register', ['as' => 'admin.register.get', 'uses' => 'Auth\AuthController@showRegistrationForm']);
        Route::post('register', ['as' => 'admin.register.post', 'uses' => 'Auth\AuthController@register']);

        // Password Reset Routes...
        Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
        Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
        Route::post('password/reset', 'Auth\PasswordController@reset');

        // Change Password
        Route::post('/changePass', ['as' => 'admin.changePass.postChangePass', 'uses'=>'ProfileController@postChangePass']);

        /*ROLE, PERMISSION*/
        Route::get('/create-role', ['as' => 'admin.createRole', 'uses' => 'Auth\RoleController@createRole']);
        Route::post('/create-role', ['as' => 'admin.postCreateRole', 'uses' => 'Auth\RoleController@postCreateRole']);
        Route::post('/ajax-role', ['as' => 'admin.ajaxCreateRole', 'uses' => 'Auth\RoleController@postAjaxRole']);
        Route::post('/ajax-permission', ['as' => 'admin.ajaxCreatePermission', 'uses' => 'Auth\RoleController@postAjaxPermission']);

        Route::group(["middleware" => "can_login"], function(){

            Route::get('dashboard', ['as' => 'admin.dashboard', 'uses' => 'DashboardController@index']);
            //   PORFILE
            Route::get('/profile', ['as' => 'admin.profile.index', 'uses' => 'ProfileController@index']);

            /*USER MANAGEMENT*/
            Route::get('user/getData', ['as' => 'admin.user.getData', 'uses' => 'UserManagementController@getData']);
            Route::post('user/deleteAll', ['as' => 'admin.user.deleteAll', 'uses' => 'UserManagementController@deleteAll']);
            Route::post('user/updateStatus', ['as' => 'admin.user.updateStatus', 'uses' => 'UserManagementController@updateStatus']);
            Route::post('user/createUserByAdmin', ['as' => 'admin.user.createByAdmin', 'uses' => 'Auth\AuthController@registerByAdmin']);
            Route::resource('/user','UserManagementController');

            // MULTI PHOTOs
            Route::get('photo', ['as'=>'admin.photo.index', 'uses'=>'MultiPhotoController@getIndex']);
            Route::get('photo/create', ['as'=>'admin.photo.create', 'uses'=>'MultiPhotoController@getCreate']);
            Route::post('photo/create', ['as'=>'admin.photo.postCreate', 'uses'=>'MultiPhotoController@postCreate']);
            Route::get('photo/edit/{id}',['as' => 'admin.photo.edit', 'uses'=>'MultiPhotoController@getEdit']);
            Route::put('photo/edit/{id}',['as' => 'admin.photo.update', 'uses'=>'MultiPhotoController@postEdit']);
            Route::delete('photo/delete/{id}', ['as' => 'admin.photo.destroy', 'uses'=>'MultiPhotoController@destroy']);
            Route::post('photo/deleteAll', ['as' => 'admin.photo.deleteAll', 'uses'=>'MultiPhotoController@deleteAll']);

            /*CATEGORY*/
            Route::get('category/getData', ['as' => 'admin.category.getData', 'uses' => 'CategoryController@getData']);
            Route::post('category/deleteAll', ['as' => 'admin.category.deleteAll', 'uses' => 'CategoryController@deleteAll']);
            Route::post('category/updateStatus', ['as' => 'admin.category.updateStatus', 'uses' => 'CategoryController@updateStatus']);
            Route::post('category/postAjaxUpdateOrder', ['as' => 'admin.category.postAjaxUpdateOrder', 'uses' => 'CategoryController@postAjaxUpdateOrder']);
            Route::resource('category', 'CategoryController');

            /* COMPANY */
            Route::any('company/{id?}', ['as' => 'admin.company.index', 'uses' => 'CompanyController@getInformation']);


            /*PRODUCT*/
            Route::get('product/getData', ['as' => 'admin.product.getData', 'uses' => 'ProductController@getData']);
            Route::post('product/deleteAll', ['as' => 'admin.product.deleteAll', 'uses' => 'ProductController@deleteAll']);
            Route::post('product/postAjaxUpdateOrder', ['as' => 'admin.product.postAjaxUpdateOrder', 'uses' => 'ProductController@postAjaxUpdateOrder']);
            Route::post('product/AjaxRemovePhoto', ['as' => 'admin.product.AjaxRemovePhoto', 'uses' => 'ProductController@AjaxRemovePhoto']);
            Route::post('product/AjaxUpdatePhoto', ['as' => 'admin.product.AjaxUpdatePhoto', 'uses' => 'ProductController@AjaxUpdatePhoto']);
            Route::post('product/updateStatus', ['as' => 'admin.product.updateStatus', 'uses' => 'ProductController@updateStatus']);
            Route::post('product/updateHotProduct', ['as' => 'admin.product.updateHotProduct', 'uses' => 'ProductController@updateHotProduct']);
            Route::resource('product', 'ProductController');

        });
    });
});
