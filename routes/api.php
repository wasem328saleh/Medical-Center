<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\MedicalserviceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CodeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
    Route::post('regester',[UserController::class, 'store']);
    Route::post('login',[UserController::class, 'login']);
    Route::post('logout',[UserController::class, 'logout'])->middleware(['auth.guard:user-api']);
    Route::get('profile',[UserController::class, 'profile'])->middleware(['auth.guard:user-api']);
    Route::get('MyProducts',[UserController::class, 'my_products'])->middleware(['auth.guard:user-api']);
    Route::post('image',[UserController::class, 'uploadImage'])->middleware(['auth.guard:user-api']);
   


    
    Route::post('add',[ProductController::class, 'add'])->middleware(['auth.guard:user-api']);
    Route::post('shwo/{id}',[ProductController::class, 'getProductById'])->middleware(['auth.guard:user-api']);
    Route::get('allproduct',[ProductController::class, 'getAllProducts'])->middleware(['auth.guard:user-api']);
    Route::post('edit/{id}',[ProductController::class, 'edit'])->middleware(['auth.guard:user-api']);
    Route::delete('delete/{id}',[ProductController::class, 'destroy'])->middleware(['auth.guard:user-api']);
    Route::get('categoryAndProductsById/{id}',[ProductController::class, 'categoryandproductsbyid']);
    Route::get('Allcategory',[ProductController::class, 'allcategory']);
    Route::get('AllcategoryAndProducts',[ProductController::class, 'Allcategoryandproducts']);
    Route::post('update/{id}',[ProductController::class, 'update'])->middleware(['auth.guard:user-api']);
    Route::post('serch',[ProductController::class, 'serch']);
    Route::post('sort',[ProductController::class, 'sort']);
    Route::post('addcomment/{id}',[ProductController::class, 'addcomment'])->middleware(['auth.guard:user-api']);
    Route::get('allcommentswithproduct/{id}',[ProductController::class, 'allcommentswithproduct']);
    Route::post('addlikeAnddeslike/{id}',[ProductController::class, 'likeAnddeslike'])->middleware(['auth.guard:user-api']);
    Route::get('statusLikeUser/{id}',[ProductController::class, 'getstatususerlike'])->middleware(['auth.guard:user-api']);*/
    Route::post('code',[CodeController::class, 'create']);
    Route::get('ww',[UserController::class, 'index']);
    Route::post('VerifiedCode',[CodeController::class, 'successCode']);
    Route::post('regesterPatient',[PatientController::class, 'store']);
    Route::post('regesterDoctor',[DoctorController::class, 'store']);
    Route::post('workingDayByDoctor/{id}',[DoctorController::class, 'workingDayByDoctor']);
    Route::get('show',[DoctorController::class, 'index']);
    Route::post('serchBySepecialize',[DoctorController::class, 'serch']);
    Route::post('addWorkingDay',[DoctorController::class, 'addWorkingDay'])->middleware(['auth.guard:user-api']);
    Route::post('addTags',[DoctorController::class, 'addTags'])->middleware(['auth.guard:user-api']);
    Route::post('regesterAdmin',[AdminController::class, 'store']);
    Route::post('addClinic',[ClinicController::class, 'create']);
    Route::get('allclinics',[ClinicController::class, 'index']);
    Route::post('login',[UserController::class, 'login']);
    Route::put('teest',[UserController::class, 'teeeest']);
    Route::post('teestss',[AppointmentController::class, 'teeeest']);
    Route::post('tee',[AppointmentController::class, 'freeTimeDoctor']);
    Route::post('creatApp',[AppointmentController::class, 'create'])->middleware(['auth.guard:user-api']);
    Route::post('logout',[UserController::class, 'logout'])->middleware(['auth.guard:user-api']);

    Route::post('creatconsultation',[ConsultationController::class, 'create'])->middleware(['auth.guard:user-api']);
    
    Route::get('allconsultation',[ConsultationController::class, 'index']);
    Route::get('showconsultation/{id}',[ConsultationController::class, 'show']);
    Route::get('allconsultationtodoctors',[ConsultationController::class, 'indextodoctors']);
    Route::get('myconsultation',[ConsultationController::class, 'myconsultation'])->middleware(['auth.guard:user-api']);
    Route::post('storeAnswer/{id}',[ConsultationController::class, 'storeAnswer'])->middleware(['auth.guard:user-api']);

    Route::post('createmedicalservice',[MedicalserviceController::class, 'create'])->middleware(['auth.guard:user-api']);
    Route::post('acceptancemedicalservice/{id}',[MedicalserviceController::class, 'acceptance']);
    Route::post('unacceptancemedicalservice/{id}',[MedicalserviceController::class, 'unacceptance']);
    Route::get('allMedicalserviceWaiting',[MedicalserviceController::class, 'index']);