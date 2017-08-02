<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->group(['prefix' => 'v1','namespace' => 'App\Http\Controllers', 'middleware' => 'oauth'], function($app){
    $app->get('email','ApiController@sendEmail');

    $app->get('product', 'ApiController@allProduct');
    $app->post('register', 'ApiController@register');
    $app->post('login', 'ApiController@loginUser');
    $app->get('product/best-seller', 'ApiController@filterSeller');
    $app->get('product/new-arrival', 'ApiController@filterNew');
    $app->get('product/trending', 'ApiController@filterPopular');
    $app->get('product/{id}', 'ApiController@productDetail');
    $app->get('user/{id}', 'ApiController@usersProfile');
    $app->post('user/update','ApiController@updateProfile');
    $app->get('user/shipping/{id}', 'ApiController@usersShipping');
    $app->post('shipping/update', 'ApiController@updateShipping');
    $app->get('user/order/{id}', 'ApiController@usersOrder');
    $app->get('order/detail/{id}', 'ApiController@usersOrderDetail');
    $app->get('category', 'ApiController@allCategory');
    $app->get('product/{level}/{id_category}', 'ApiController@productbyCategory');
    $app->get('cart/{id_session}', 'ApiController@getCart');
    $app->post('cart/update', 'ApiController@updateCart');
    $app->post('payment', 'ApiController@paymentCreate');
    $app->get('payment/cancel/{id}', 'ApiController@paymentCancel');

});


$app->post('oauth/access_token', function() {
    return response()->json(Authorizer::issueAccessToken());
});

$app->get('test-email', 'ApiController@testEmail');
$app->get('reg-confirm/{id}', 'apiMaintenance@reg_confirm');
$app->get('forgot-password/{id}', 'apiMaintenance@forgotPassword');
$app->post('/update-password', 'apiMaintenance@updatePassword');
$app->get('/cancel-withdraw/{id}', 'apiMaintenance@cancel_withdrawal');


