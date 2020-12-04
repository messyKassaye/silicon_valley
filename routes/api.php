<?php

use Dingo\Api\Routing\Router;

/** @var Router $api */
$api = app(Router::class);

$api->version('v1', function (Router $api) {
    $api->group(['prefix' => 'auth'], function(Router $api) {
        $api->post('signup', 'App\\Api\\V1\\Controllers\\SignUpController@signUp');
        $api->post('login', 'App\\Api\\V1\\Controllers\\LoginController@login');

        $api->post('recovery', 'App\\Api\\V1\\Controllers\\ForgotPasswordController@sendResetEmail');
        $api->post('reset', 'App\\Api\\V1\\Controllers\\ResetPasswordController@resetPassword');

        $api->post('logout', 'App\\Api\\V1\\Controllers\\LogoutController@logout');
        $api->post('refresh', 'App\\Api\\V1\\Controllers\\RefreshController@refresh');
        $api->get('me', 'App\\Api\\V1\\Controllers\\UserController@me');
        $api->post('config','App\\Api\\V1\\Controllers\\ConfigController@store');

    });



    $api->group(['middleware' => 'jwt.auth'], function(Router $api) {
        $api->get('protected', function() {
            return response()->json([
                'message' => 'Access to protected resources granted! You are seeing this text as you provided the token correctly.'
            ]);
        });

        $api->get('refresh', [
            'middleware' => 'jwt.refresh',
            function() {
                return response()->json([
                    'message' => 'By accessing this endpoint, you can refresh your access token at each request. Check out this response headers!'
                ]);
            }
        ]);


        $api->resource('posts','App\\Api\\V1\\Controllers\\PostController');
        $api->resource('products','App\\Api\\V1\\Controllers\\ProductsController');
        $api->resource('matches','App\\Api\\V1\\Controllers\\LikeController');
        $api->resource('utility','App\\Api\\V1\\Controllers\\UserUtilityController');
        $api->resource('locations','App\\Api\\V1\\Controllers\\LocationController');
        $api->resource('medias','App\\Api\\V1\\Controllers\\MediaController');
        $api->resource('passions','App\\Api\\V1\\Controllers\\PassionController');
        $api->post('change_profile','App\\Api\\V1\\Controllers\\UserController@changeProfile');
        $api->resource('chats','App\\Api\\V1\\Controllers\\ChatController');
        $api->get('user/{id}','App\\Api\\V1\\Controllers\\UserController@show');
        $api->resource('reports','App\\Api\\V1\\Controllers\\ReportController');


   });

    $api->resource('file_upload','App\\Api\\V1\\Controllers\\FileUploaderController');
    
    $api->get('hello', function() {
        return response()->json([
            'message' => 'This is a simple example of item returned by your APIs. Everyone can see it.'
        ]);
    });
});
