<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('show-post-2', 'AjaxController@showPosts');
Route::get('show-post', 'AjaxController@showPosts');
Route::get('paginate', 'AjaxController@paginate');

Route::get('province/{id}', 'AjaxController@getProvince');
Route::get('values/{id}', 'AjaxController@getAttrValues');
Route::get('update-quantity/{id_1}/{id_2}', 'AjaxController@updateQty');
Route::get('confirm-register/{id}', 'AjaxController@regConfirm');
Route::post('detail-filter', 'AjaxController@filterDetail');
Route::post('detail-price', 'AjaxController@priceDetail');
Route::get('create-wishlist/{id}', 'AjaxController@wishlistCreate');
Route::get('remove-wishlist/{id}', 'AjaxController@wishlistRemove');
Route::get('check-wishlist/{id}', 'AjaxController@wishlistCheck');
Route::get('/buy-detail/{id}', 'AjaxController@buyDetail');
Route::get('/buy-direct/{id}', 'AjaxController@buyDirect');
Route::get('/get-cart', 'AjaxController@cart');
Route::get('/category-1/{id_1}/{id_2}', 'AjaxController@product_category_1');

Route::get('/vt_transaction', 'PagesController@transaction');
Route::post('/vt_transaction', 'TransactionController@transaction_process');
Route::post('/vt_notif', 'VtwebController@notification');

Route::group([/*'middleware' => ['web']*/], function () { // kalo pake mod web error ga tampil  
    Route::post('/process-register', 'HomeController@processRegister');
    Route::post('/process-login','HomeController@processLogin');    
    //Route::post('/buy-detail', 'HomeController@buyDetail');    
    Route::post('/checkout/quantity', 'HomeController@updateUserCart');    
    Route::post('/checkout/guest', 'HomeController@chkoutGuest');
    Route::post('/checkout/update-address', 'HomeController@updateAddress');    
    Route::post('/payment', 'HomeController@chkPayment');
    Route::post('/wishlist/create/{}', 'HomeController@productSearch');

    Route::get('/', 'HomeController@home');
    Route::get('/c/{id_1}', 'HomeController@category_1');
    Route::get('/c/{id_1}/{id_2}', 'HomeController@category_2');
    Route::get('/c/{id_1}/{id_2}/{id_3}', 'HomeController@category_3');
    Route::get('/product/{id}', 'HomeController@productDetail');
    Route::get('/payment/success/{id}', 'HomeController@successPayment');
    Route::get('/vtweb/{id_1}/{id_2}', 'VtwebController@vtweb');
    Route::get('/summary', 'HomeController@chksummary');
    Route::get('/checkout/address', 'HomeController@chkoutAddress');
    Route::get('/checkout/signin', 'HomeController@chkoutSignin');
    Route::get('/cart', 'HomeController@cart');
    Route::get('/cart/delete/{id}', 'HomeController@cartDelete');
    Route::get('/signout', 'HomeController@signout');
    Route::get('/buy/{id}', 'HomeController@buy');
    Route::get('/signin-signup', 'HomeController@signin');
    Route::get('/search-product/{id_1?}/{id_2?}', 'HomeController@productSearch');
});

Route::group(['middleware' => ['auth']], function(){
    Route::get('/users/profile', 'HomeController@usersProfile');
    Route::post('/update-profile','HomeController@updateProfile');
    Route::get('/users/shipping', 'HomeController@usersShipping');
    Route::post('/update-shipping','HomeController@updateShipping');
    Route::get('/users/orders', 'HomeController@usersOrder');
    Route::get('/users/wishlist', 'HomeController@usersWishlist');
    Route::get('/users/wishlist/delete/{id}', 'HomeController@deleteWishlist');
    Route::get('/users/orders/detail/{id}', 'HomeController@usersOrderDetail');
});

Route::group(['middleware' => ['web']], function(){
	Route::get('/login','Auth\AuthController@showLoginForm');
  Route::post('/login','Auth\AuthController@login');
  Route::get('/logout','Auth\AuthController@logout');

  // Registration Routes...
  Route::get('register', 'Auth\AuthController@showRegistrationForm');
  Route::post('register', 'Auth\AuthController@register');
	Route::get('/home', 'HomeController@index');
});

Route::group(['prefix' => 'isa-cms'], function () {
  Route::group(['middleware' => ['web']], function () {
    //Login Routes...
    Route::get('/', function () {
	    	$title     = 'Login - ISA CMS';
	    	return view('backend.layout.login', compact('title'));
	  });
    Route::post('/login','AdminAuth\AuthController@login');
    Route::get('/logout','AdminAuth\AuthController@logout');
  });
  Route::group(['middleware' => ['admin']], function () {
    Route::get('/dashboard', 'AdminController@dashboard');
    Route::group(['prefix' => 'categories'], function () {
      Route::get('/','AdminController@category');
      Route::get('/create','AdminController@categoryCreate');
      Route::post('/store', 'AdminController@categoryStore');
      Route::get('/edit/{id}','AdminController@categoryEdit');
      Route::post('/update', 'AdminController@categoryUpdate');
      Route::get('/delete/{id}','AdminController@categoryDelete');
    });
    Route::group(['prefix' => 'products'], function () {
      Route::get('/','AdminController@products');
      Route::get('/create','AdminController@productCreate');
      Route::post('/store', 'AdminController@productStore');
      Route::get('/edit/{id}','AdminController@productEdit');
      Route::post('/update', 'AdminController@productUpdate');
      Route::get('/delete/{id}','AdminController@productDelete');
      Route::get('/picture/{id}','AdminController@productPicture');
      Route::post('/store-picture', 'AdminController@productsStorePicture');
      Route::get('/delete-picture/{id}', 'AdminController@productDeletePicture');
    });
    Route::group(['prefix' => 'products/combination'], function () {
      Route::get('/list/{id}','AdminController@productCombination');
      Route::get('/create','AdminController@productCombinationCreate');
      Route::post('/store', 'AdminController@productCombinationStore');
      Route::get('/edit/{id}','AdminController@productCombinationEdit');
      Route::post('/update', 'AdminController@productCombinationUpdate');
      Route::get('/delete/{id}','AdminController@productCombinationDelete');
    });

    Route::group(['prefix' => 'brands'], function () {
      Route::get('/','AdminController@brands');
      Route::get('/create','AdminController@brandsCreate');
      Route::post('/store', 'AdminController@brandsStore');
      Route::get('/edit/{id}','AdminController@brandsEdit');
      Route::post('/update', 'AdminController@brandsUpdate');
      Route::get('/delete/{id}','AdminController@brandsDelete');
    });
    Route::group(['prefix' => 'attributes'], function () {
      Route::get('/','AdminController@attributes');
      Route::get('/create','AdminController@attributesCreate');
      Route::post('/store', 'AdminController@attributesStore');
      Route::get('/edit/{id}','AdminController@attributesEdit');
      Route::post('/update', 'AdminController@attributesUpdate');
      Route::get('/delete/{id}','AdminController@attributesDelete');
    });
    Route::group(['prefix' => 'attributes/values'], function () {
      Route::get('/list/{id}','AdminController@values');
      Route::get('/create','AdminController@valuesCreate');
      Route::post('/store', 'AdminController@valuesStore');
      Route::get('/edit/{id}','AdminController@valuesEdit');
      Route::post('/update', 'AdminController@valuesUpdate');
      Route::get('/delete/{id}','AdminController@valuesDelete');
    });
    Route::group(['prefix' => 'orders'], function () {
      Route::get('/','AdminController@order');
      Route::get('/detail/{id}','AdminController@orderDetail');
      Route::get('/delete/{id}','AdminController@orderDelete');
      Route::post('/update', 'AdminController@orderUpdate');
    });
    Route::group(['prefix' => 'customers'], function () {
      Route::get('/','AdminController@customers');
      Route::get('/edit/{id}','AdminController@customersEdit');
      Route::get('/delete/{id}','AdminController@customersDelete');
      Route::post('/update', 'AdminController@customersUpdate');
    });
    Route::group(['prefix' => 'users'], function () {
      Route::get('/', 'AdminController@users');
      Route::get('/create', 'AdminController@usersCreate');
      Route::post('/store', 'AdminController@usersStore');
      Route::get('/delete/{id}', 'AdminController@usersDelete');
      Route::get('/edit/{id}', 'AdminController@usersEdit');
      Route::post('/update', 'AdminController@usersUpdate');
    });
  });
});
