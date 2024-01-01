<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseDepotController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ForgetPassword;
use App\Http\Controllers\MedicamentController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SpecialEmployeController;
use App\Http\Controllers\SupplierCommandsController;
use App\Http\Middleware\ProtectRoutes;
use App\Models\Pharmacy;
use App\Models\SpecialEmploye;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\View;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::group(['middleware' => [ProtectRoutes::class . ':protect,special_employe']], function () {

    Route::get('/specialEmploye{id}', [SpecialEmployeController::class, 'show'])->name('specialEmploye');
    Route::get('/specialEmploye{id}/pharmacies', [SpecialEmployeController::class, 'pharmacies'])->name('pharmacies.show');
    Route::get('/specialEmploye{id}/pharmacists', [SpecialEmployeController::class, 'pharmacists'])->name('pharmacists.show');
    Route::get('/specialEmploye{id}/customers', [SpecialEmployeController::class, 'customers'])->name('customers.show');
    Route::get('/specialEmploye{id}/specialEmployes', [SpecialEmployeController::class, 'specialEmployes'])->name('specialEmployes.show');
    Route::get('/specialEmploye{id}/commands', [SpecialEmployeController::class, 'commands'])->name('commands.show');
    Route::get('/specialEmploye{id}/suppliers', [SpecialEmployeController::class, 'suppliers'])->name('suppliers.show');
    Route::get('/specialEmploye{id}/basedepot', [SpecialEmployeController::class, 'basedepotshow'])->name('baseDepot.show');
    Route::get('/specialEmploye{id}/suppliercommandsshow', [SpecialEmployeController::class, 'supplierCommandsShow'])->name('supplier.commands.show');
});

Route::group(['middleware' => [ProtectRoutes::class . ':protect,special_employe,pharmacist']], function () {
    Route::get('/suppliercommandform{id}', [SpecialEmployeController::class, 'supplierCommandFormShow'])->name('supplier.command.form.show');
});

Route::group(['middleware' => [ProtectRoutes::class . ':protect,customer,pharmacist']], function () {
    Route::get('/shoppingcart/{id}', [CartController::class, 'index'])->name('cart.index');
    Route::get('/profile/{id}', [CustomerController::class, 'show'])->name('Customer');
    Route::get('/commands/{id}', [CustomerController::class, 'commands'])->name('customer.commands.show');
    Route::get('/shop/{id}', [ShopController::class, 'show'])->name('shop');
});

Route::group(['middleware' => [ProtectRoutes::class . ':protect,pharmacist']], function () {
    Route::get('/depot/{id}', [PharmacistController::class, 'index'])->name('depot.index');
    Route::get('/pharmacist{id}/suppliercommandsshow', [PharmacistController::class, 'pharmacistSupplierCommandsShow'])->name('pharmacist.supplier.commands.show');
});

Route::get('special-emp/basedepot/item/update', [BaseDepotController::class, 'updateBaseDepotItem'])->name('baseDepot.item.update');
Route::get('special-emp/basedepot/item/delete', [BaseDepotController::class, 'deleteBaseDepotItem'])->name('baseDepot.item.delete');

Route::get('/special-emp/pharmacies/add', [PharmacyController::class, 'addPharmacy'])->name('pharmacy.add');
Route::get('/special-emp/pharmacies/delete', [PharmacyController::class, 'deletePharmacy'])->name('pharmacy.delete');
Route::get('/special-emp/pharmacies/update', [PharmacyController::class, 'updatePharmacy'])->name('pharmacy.update');
Route::get('/special-emp/pharmacies/edit', [PharmacyController::class, 'editPharmacy'])->name("pharmacy.edit");

Route::get('/special-emp/pharmacist/add', [PharmacistController::class, 'addPharmacist'])->name('pharmacist.add');
Route::get('/special-emp/pharmacist/delete', [PharmacistController::class, 'deletePharmacist'])->name('pharmacist.delete');
Route::get('/special-emp/pharmacist/update', [PharmacistController::class, 'updatePharmacist'])->name('pharmacist.update');

Route::get('/special-emp/customer/delete', [CustomerController::class, 'customerDelete'])->name('customer.delete');

Route::get('/special-emp/items/ship', [SpecialEmployeController::class, 'itemsShip'])->name('items.ship');
Route::get('/customer/items/arrive', [CustomerController::class, 'itemsArrived'])->name('items.arrived');

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');


Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/products', [MedicamentController::class, 'show'])->name('medications');
Route::post('/filter-medicaments', [MedicamentController::class, 'filter'])->name('filter');



Route::get('/forget-password', [ForgetPassword::class, 'forgetPassword'])->name('forget.password');
Route::post('/forget-password', [ForgetPassword::class, 'forgetPasswordPost'])->name('forget.password.post');
Route::get('/reset-password/{token}', [ForgetPassword::class, 'resetPassword'])->name('reset.password');
Route::post('/reset-password', [ForgetPassword::class, 'resetPasswordPost'])->name('reset.password.post');




Route::post('/cart/add', [ShopController::class, 'addCart'])->name('cart.add');
Route::get('/cart/cancelCommand', [ShopController::class, 'cancelCommand'])->name('cart.cancelCommand');
Route::get('/cart/delete', [ShopController::class, 'deleteCart'])->name('cart.delete');
Route::get('/cart/confirmCommand', [ShopController::class, 'confirmCommand'])->name('cart.confirmCommand');




Route::post('/specialemp/supplier/command', [SupplierCommandsController::class, 'store'])->name('suppler.command.store');


Route::get('pharmacist/medication/price/update', [PharmacistController::class, 'updatePrice'])->name('med.price.update');


Route::get('special-emp/supplier/update', [SupplierCommandsController::class, 'updateSupplier'])->name('supplier.update');
Route::get('special-emp/supplier/add', [SupplierCommandsController::class, 'addSupplier'])->name('supplier.add');
Route::get('special-emp/supplier/delete', [SupplierCommandsController::class, 'deleteSupplier'])->name('supplier.delete');


Route::get('/special-emp/items/arrived', [SpecialEmployeController::class, 'itemsArrived'])->name('supplier.items.arrived');
Route::get('/pharmacist/items/arrived', [PharmacistController::class, 'itemsarrived'])->name('pharmacist.supplier.items.arrived');

Route::view('/unauthorized', 'unauthorized')->name('unauthorized');

Route::view('/access-denied', 'access-denied')->name('access-denied');
