<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\VisitorLogController;
use App\Http\Controllers\ContributorController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\VisitorLog;



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

// route for the landing page 
Route::get('/', function () {
    return view('welcome');
});

// use App\Http\Controllers\TranslationController;
Route::get('/translate', [TranslationController::class, 'index']);
Route::post('/translate/ajax', [TranslationController::class, 'ajaxTranslate'])->name('ajax.translate');
Route::post('/ajax/suggestions', [TranslationController::class, 'ajaxSuggestions'])->name('ajax.suggestions');

// Translate NavBar // Visitor Logs
// Route::get('/translate', function () {
//     return view('translate');
// })->name('translate');

Route::get('/translate', function () {
    VisitorLog::create([
        'ip_address' => Request::ip(),
        'action' => 'translator',
        'user_agent' => Request::userAgent(),
    ]);

    return view('translate');
})->name('translate');


Route::get('/dictionary', [DictionaryController::class, 'index'])->name('dictionary.index');

Route::get('/about', [PageController::class, 'about']);

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');


// use App\Http\Controllers\ContributorController;
// use App\Http\Controllers\AdminSubmissionController;

Route::get('/contribute', function () {
    return view('contribute');
})->name('contribute.form');

Route::post('/contribute', [ContributorController::class, 'store'])->name('contribute.store');


Route::get('/manage-entries', [EntryController::class, 'index'])->name('manage.entries');
Route::post('/dictionary/store', [EntryController::class, 'storeDictionary'])->name('dictionary.store');
Route::post('/translation/store', [EntryController::class, 'storeTranslation'])->name('translation.store');


// redirects to specific dashboard based on the role of the user 
// Route::get('/dashboard', function () {
//     if(Auth::user()->roles[0]->name == "admin")
//     {
//        // return Auth::user()->roles[0]->name;
//         return view('admin.dashboard');
//     }
//     else
//     {
//         // return Auth::user()->roles[0]->name;
//         return view('users.dashboard');
//     } 
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/dashboard', function () {
//         $role = Auth::user()->roles[0]->name;

//         if ($role === 'admin') {
//             return redirect()->route('admin.dashboard');
//         } else {
//             return redirect()->route('users.dashboard');
//         }
//     })->name('dashboard');
// });

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard')->middleware(['auth', 'verified']);



// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



// admin routes here 
Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->middleware('can:admin-access')->group(function(){

    // add routes here for admin 
    Route::resource('/users','UserController',['except' => ['create','store','destroy']]);
    Route::get('/userfeedbacks','UserController@userfeedback')->name('userfeedback');

    // Translation and dictionary management
    Route::resource('translations','TranslationController');
    Route::resource('dictionary', 'DictionaryController');
    Route::resource('entries', 'EntryController');

    Route::patch('/dictionary/{id}/toggle-visibility', [App\Http\Controllers\Admin\DictionaryController::class, 'toggleVisibility'])
        ->name('dictionary.toggleVisibility');

    Route::patch('/translations/{id}/toggle-visibility', [App\Http\Controllers\Admin\TranslationController::class, 'toggleVisibility'])
        ->name('translations.toggleVisibility');

    // Feedback messages
    Route::get('feedbacks', 'FeedbackController@index')->name('feedbacks.index');
    Route::delete('feedbacks/{id}', 'FeedbackController@destroy')->name('feedbacks.destroy');
    Route::get('feedbacks/archived', 'FeedbackController@archived')->name('feedbacks.archived');
    Route::post('feedbacks/{id}/restore', 'FeedbackController@restore')->name('feedbacks.restore');

    // Visitor Logs
    Route::get('visitor-logs', 'VisitorLogController@index')->name('visitor_logs.index');

    // Team
    Route::get('/team', 'TeamController@index')->name('team.index');
    Route::get('/team/{id}/edit', 'TeamController@edit')->name('team.edit');
    Route::put('/team/{id}', 'TeamController@update')->name('team.update');


    Route::resource('team', 'TeamController');
    Route::resource('gallery', 'GalleryController');


    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    // Contributors
    Route::get('submissions', 'SubmissionController@index')->name('submissions.index');
    Route::post('submissions/{id}/approve', 'SubmissionController@approve')->name('submissions.approve');
    Route::post('submissions/{id}/reject', 'SubmissionController@reject')->name('submissions.reject');
    Route::post('submissions/{id}/undo', 'SubmissionController@undo')->name('submissions.undo');


    Route::get('analytics', 'AnalyticsController@index')->name('analytics');
    
    Route::get('global-search', 'SearchController@search')->name('global-search');
    
    
});

// -------------------------
// 🧍 PROFILE ROUTES (FOR LOGGED-IN USERS / ADMINS)
// -------------------------
Route::middleware(['auth'])->group(function () {
    // Profile Page
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Password Update
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});


// // users routes here 
// Route::namespace('App\Http\Controllers\Users')->prefix('users')->name('users.')->middleware('can:user-access')->group(function(){

//     // add routes here for users 
//     Route::resource('/feedback','CTRLFeedbacks',['except' => ['update','edit','destroy']]);

//     Route::get('/myfeedbacks','CTRLFeedbacks@myfeedback')->name('myfeedback');

//     Route::resource('/products','CTRLproducts');

//     // eto route ng search products
//     Route::get('/searchproducts','CTRLproducts@searchproducts')->name('searchproducts');

// });







require __DIR__.'/auth.php';
