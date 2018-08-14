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
Route::get('/', function (){
   return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//////////////////////////****PROFILE****/////////////////////////
Route::get('/pages/profile','ProfileController@show');
Route::post('/pages/profile','ProfileController@updateProfile');
Route::post('/profile/passwd','ProfileController@updatePasswd');


////////////////////////////////////////////////////////////////




//////////////////////////****ITEMS****/////////////////////////
Route::get('/pages/items','ItemsController@show');
Route::get('/pages/items/showadd','ItemsController@showadd');
Route::post('/items/add','ItemsController@add');

Route::get('/items/edit','ItemsController@edit');
Route::post('/items/edit','ItemsController@update');

Route::get('/items/init','ItemsController@showSelect');
Route::post('/items/init','ItemsController@addMainCat');
Route::post('/items/init1','ItemsController@showSelect2');
Route::post('/items/init2','ItemsController@showItemAdd');
Route::post('/items/init3','ItemsController@modifyOptions');

Route::get('/items/init2','ItemsController@showItemAdd');////////

Route::post('/items/initsub','ItemsController@addSubCat');
Route::get('/modrequest/remove/{data}','ItemsController@removeSubCat');


Route::get('/items/view','ItemsController@viewItem');
Route::get('/items/disable/{itemcode}','ItemsController@disable');
Route::get('/items/enable/{itemcode}','ItemsController@enable');

Route::get('/items/restock','ItemsController@showRestockDialog');
Route::post('/items/restock','ItemsController@restockrequest');

Route::get('/items/report/inventory','ItemsController@generateInventoryList');

////////////////////////////////////////////////////////////////

Route::get('/pages/categories','CategoriesController@show');


//////////////////****BRANDS****//////////////////////
Route::get('/pages/brands','BrandsController@show');
Route::post('/pages/brands/add','BrandsController@add');
Route::get('/brand/delete/{brandcode}','BrandsController@delete');
Route::get('/pages/brands/showedit/{brandcode}','BrandsController@showedit');
Route::post('/brands/edit','BrandsController@edit');
/////////////////////////////////////////////////////////////


//////////////////////****CUSTOMERS****/////////////////////////
Route::get('/pages/customers','CustomersController@show');
//Route::post('/pages/customers','CustomersController@show');
Route::post('/customers/add','CustomersController@addNew');

/////////////////////////////////////////////////////////////


//////////////////////****DEALERS****/////////////////////////
Route::get('/pages/dealers','DealersController@show');
Route::post('/dealers/add','DealersController@addNew');
/////////////////////////////////////////////////////////////


////////////////////////////****CART****/////////////////////////////
Route::get('/pages/cart/sales','CartController@show');
Route::get('/pages/cart/dealer','CartController@showFromDealer');
Route::get('/cart/add','CartController@addToCart');
Route::get('/cart/addall','CartController@addAllToCart');
Route::get('/cart/remove','CartController@removeFromCart');
Route::get('/cart/minus','CartController@minus');

/////////////////////////////////////////////////////////////////////


////////////////////////////****INVOICE****/////////////////////////////
Route::get('/pages/invoice/sales','InvoiceController@showSalesInvoices');
Route::post('/pages/invoice/sales','InvoiceController@filterDateSales');

Route::get('/pages/invoice/dealer','InvoiceController@showDealerInvoices');
Route::post('/pages/invoice/dealer','InvoiceController@filterDateDealer');

Route::get('/invoice/generatesalesinvoice','InvoiceController@showSelectCustomer');
Route::post('/invoice/generatesalesinvoice','InvoiceController@generateSalesInvoice');

Route::get('/invoice/generatedealerinvoice','InvoiceController@showSelectDealer');
Route::post('/invoice/generatedealerinvoice','InvoiceController@generateDealerInvoice');



Route::get('/customers/generateinvoice','InvoiceController@generateSalesInvoice');


Route::get('/invoice/showsalesinvoice','InvoiceController@showSalesInvoiceDetail');
Route::get('/invoice/showdealernvoice','InvoiceController@showDealerInvoiceDetail');



/////////////////////////////////////////////////////////////////////



//////////////////////////////////////****SUBCATEGORIES****////////////////////////////////////////
Route::get('/pages/categories/addsubcat/{mainCategory}','SubCategoriesController@addNewSubCatShow');
Route::get('/pages/categories/addnew/subcat','SubCategoriesController@add');
Route::get('/pages/categories/delete/subcat/{subCategory}','SubCategoriesController@delete');
Route::get('/pages/categories/edit/subcat/{subCategory}','SubCategoriesController@subCatEditShow');

Route::post('/pages/categories/addnew/subcat','CategoriesController@addNew');
/////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////****OPTIONS****/////////////////////////////
Route::get('/subcategory/edit/addoption/{value}','OptionsController@show');
Route::get('/subcategory/edit/update','OptionsController@update');
Route::get('/subcategory/edit/addnew','OptionsController@add');
/////////////////////////////////////////////////////////////////////



/////////////****SEARCH - (PENDING)****///////////////
Route::get('/search/item','ItemsController@search');
Route::get('/search/brand','BrandsController@search');
//////////////////////////////////////////////////////



//
//Route::get('/pages/invoice', function (){
//    return view('pages/invoice');
//});