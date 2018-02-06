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
    return redirect('/root/login');
});
Route::get('/503', function () {
    return view('errors.503');
});
Route::group(['prefix' => 'root'], function() {
    Auth::routes();
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', 'HomeController@index');
    Route::get('/home-daily', ['as' => 'homedaily', 'uses' => 'HomeController@homedaily']);
    Route::get('/addtask', ['as' => 'addtask', 'middleware' => ['role:super_user|owner'], 'uses' => 'HomeController@addtask']);
    Route::post('/addtask', ['as' => 'addtask', 'middleware' => ['role:super_user|owner'], 'uses' => 'HomeController@savetask']);
    Route::delete('/deletenote', ['as' => 'deletenote', 'middleware' => ['role:super_user|owner'], 'uses' => 'HomeController@deletenote']);
    Route::post('/assigntasks', ['as' => 'assigntasks', 'middleware' => ['role:super_user'], 'uses' => 'HomeController@assigntasks']);
    Route::get('/assignedtasks', ['as' => 'assignedtasks', 'uses' => 'HomeController@assignedtasks']);
    Route::post('/markcomplete', ['as' => 'markcomplete', 'uses' => 'HomeController@markcomplete']);
    Route::get('/home-calender', ['as' => 'homecalender', 'uses' => 'HomeController@homecalender']);


    Route::get('/home-pos', ['as' => 'homepos', 'middleware' => ['role:super_user|owner|cashier'], 'uses' => 'AccountingController@homepos']);
    Route::post('/searchpos', ['as' => 'searchpos', 'middleware' => ['role:super_user|owner|cashier'], 'uses' => 'AccountingController@searchpos']);
    Route::post('/pos-pay', ['as' => 'pospay', 'middleware' => ['role:super_user|owner|cashier'], 'uses' => 'AccountingController@pospay']);
    Route::get('/home-accounting', ['as' => 'homeaccounting', 'middleware' => ['role:super_user'], 'uses' => 'AccountingController@homeaccounting']);
    //Route::post('/saveaccountinginfo', ['as' => 'saveaccountinginfo', 'middleware' => ['role:super_user'], 'uses' => 'AccountingController@saveaccountinginfo']);
    Route::post('/showposmovements', ['as' => 'showposmovements', 'middleware' => ['role:super_user'], 'uses' => 'AccountingController@showposmovements']);
    Route::get('/viewmovement/{id}', ['as' => 'viewmovement', 'middleware' => ['role:super_user'], 'uses' => 'AccountingController@viewmovement']);
    Route::get('/editmovement/{id}', ['as' => 'editmovement', 'middleware' => ['role:super_user'], 'uses' => 'AccountingController@editmovement']);
    Route::put('/saveeditmovement/{id}', ['as' => 'saveeditmovement', 'middleware' => ['role:super_user'], 'uses' => 'AccountingController@saveeditmovement']);
    //Route::post('/today-total', ['as' => 'todaytotal', 'middleware' => ['role:super_user|owner|cashier'], 'uses' => 'AccountingController@todaytotal']);
    Route::get('/duepayment', ['as' => 'duepayment', 'middleware' => ['role:super_user|owner|cashier'], 'uses' => 'AccountingController@duepayment']);
    Route::get('/addduepayment', ['as' => 'addduepayment', 'middleware' => ['role:super_user|owner|cashier'], 'uses' => 'AccountingController@addduepayment']);
    Route::post('/addduepayment', ['as' => 'addduepayment', 'middleware' => ['role:super_user|owner|cashier'], 'uses' => 'AccountingController@saveduepayment']);
    Route::get('/editduepayment/{id}', ['as' => 'editduepayment', 'middleware' => ['role:super_user|owner'], 'uses' => 'AccountingController@editduepayment']);
    Route::put('/saveeditduepayment/{id}', ['as' => 'saveeditduepayment', 'middleware' => ['role:super_user|owner'], 'uses' => 'AccountingController@saveeditduepayment']);
    Route::delete('/deleteduepayment', ['as' => 'deleteduepayment', 'middleware' => ['role:super_user|owner'], 'uses' => 'AccountingController@deleteduepayment']);
    Route::get('/duedepandants', ['as' => 'duedepandants', 'middleware' => ['role:super_user|owner'], 'uses' => 'AccountingController@duedepandants']);
    Route::post('/pending-dueoutcome', ['as' => 'pendingdueoutcome', 'middleware' => ['role:super_user|owner'], 'uses' => 'AccountingController@pendingdueoutcome']);
	Route::post('/bk-acc-no', ['as' => 'bk-acc-no', 'middleware' => ['role:super_user|owner'], 'uses' => 'AccountingController@bkaccno']);
	Route::post('/openpos', ['as' => 'openpos', 'middleware' => ['role:super_user|owner'], 'uses' => 'AccountingController@openpos']);
	Route::post('/closepos', ['as' => 'closepos', 'middleware' => ['role:super_user|owner'], 'uses' => 'AccountingController@closepos']);


    Route::get('/home-client', ['as' => 'homeclient', 'middleware' => ['role:super_user|owner|sells|collect|cashier'], 'uses' => 'ClientController@index']);
    Route::get('/addpolicy', ['as' => 'addpolicy', 'middleware' => ['role:super_user|sells'], 'uses' => 'ClientController@addpolicy']);
    Route::post('/addpolicy', ['as' => 'addpolicy', 'middleware' => ['role:super_user|sells'], 'uses' => 'ClientController@savepolicy']);
    Route::get('/add-dependant', ['as' => 'adddependant', 'middleware' => ['role:super_user|sells'], 'uses' => 'ClientController@adddependant']);
    Route::post('/add-dependant', ['as' => 'adddependant', 'middleware' => ['role:super_user|sells'], 'uses' => 'ClientController@savedependant']);
    Route::post('/policyamount', ['as' => 'policyamount', 'middleware' => ['role:super_user|sells'], 'uses' => 'ClientController@policyamount']);
    Route::get('/listclient/{policy?}', ['as' => 'listclient', 'middleware' => ['role:super_user|owner|sells|collect|cashier'], 'uses' => 'ClientController@listclient']);
    Route::post('/showattachment', ['as' => 'showattachment', 'middleware' => ['role:super_user|owner|sells|collect|cashier'], 'uses' => 'ClientController@showattachment']);
    Route::get('/viewclient/{id}', ['as' => 'viewclient', 'middleware' => ['role:super_user|owner|sells|collect|cashier'], 'uses' => 'ClientController@viewclient']);
    Route::get('/listuser', ['as' => 'listuser', 'middleware' => ['role:super_user'], 'uses' => 'ClientController@listuser']);
    Route::get('/viewuser/{id}', ['as' => 'viewuser', 'middleware' => ['role:super_user'], 'uses' => 'ClientController@viewuser']);
    Route::post('/edituser', ['as' => 'edituser', 'middleware' => ['role:super_user'], 'uses' => 'ClientController@edituser']);
    Route::post('/deactivateuser', ['as' => 'deactivateuser', 'middleware' => ['role:super_user'], 'uses' => 'ClientController@deactivateuser']);
    Route::post('/activateuser', ['as' => 'activateuser', 'middleware' => ['role:super_user'], 'uses' => 'ClientController@activateuser']);
    Route::get('/viewpayment/{id}', ['as' => 'viewpayment', 'middleware' => ['role:super_user|owner'], 'uses' => 'ClientController@viewpayment']);
    
    Route::get('/inbox', ['as' => 'inbox', 'middleware' => ['role:super_user|owner'], 'uses' => 'EmailController@email_inbox']);
    Route::get('/viewmail/{mailid}', ['as' => 'viewmail', 'middleware' => ['role:super_user|owner'], 'uses' => 'EmailController@viewemail']);
    Route::get('/sendemail', ['as' => 'sendemail', 'middleware' => ['role:super_user|owner'], 'uses' => 'EmailController@sendemail']);
    Route::post('/dispatchemail', ['as' => 'dispatchemail', 'middleware' => ['role:super_user|owner'], 'uses' => 'EmailController@dispatchemail']);

    Route::get('/humanresource', ['as' => 'humanresource', 'middleware' => ['role:super_user|owner'], 'uses' => 'HumanResourceController@index']);
    Route::get('/rating/{id}', ['as' => 'rating', 'middleware' => ['role:super_user|owner'], 'uses' => 'HumanResourceController@rating']);
    Route::post('/rateuser', ['as' => 'rateuser', 'middleware' => ['role:super_user|owner'], 'uses' => 'HumanResourceController@rateuser']);
	Route::get('/pendingtasks', ['as' => 'pendingtasks', 'middleware' => ['role:super_user|owner'], 'uses' => 'HumanResourceController@pendingtasks']);

    Route::get('/banksview', ['as' => 'banksview', 'middleware' => ['role:super_user|owner'], 'uses' => 'SettingsController@index']);
    Route::get('/addbank', ['as' => 'addbank', 'middleware' => ['role:super_user|owner'], 'uses' => 'SettingsController@addbank']);
    Route::post('/addbank', ['as' => 'addbank', 'middleware' => ['role:super_user|owner'], 'uses' => 'SettingsController@savebank']);
});
Route::get('/root/register', function() {
    return redirect('/root/login');
});
