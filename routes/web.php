<?php

use App\Livewire\Panel\Users\UserForm;
use App\Livewire\Panel\Users\Users;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome')->name();
// });

Route::view('/', 'welcome')->name('blog');

Route::get('usercreate', UserForm::class)->name('user.create');

// Remove route cache
Route::get('/clear-route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return 'All routes cache has just been removed';
});
//Remove config cache
Route::get('/clear-config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache has just been removed';
}); 
// Remove application cache
Route::get('/clear-app-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'Application cache has just been removed';
});
// Remove view cache
Route::get('/clear-view-cache', function() {
    $exitCode = Artisan::call('view:clear');
    return 'View cache has jut been removed';
});
