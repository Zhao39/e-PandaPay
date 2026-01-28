<?php

use App\Livewire\Pages\About;
use App\Livewire\Pages\Contact;
use App\Livewire\Pages\Faq;
use App\Livewire\Pages\Home\Home;
use App\Livewire\Pages\Plans;
use App\Livewire\Pages\Terms;
use App\Models\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

require __DIR__ . '/admin/web.php';
require __DIR__ . '/user/web.php';

Route::get('/cron', function () {
    Artisan::call('schedule:run');
});

Route::name('home.')->group(function () {
    $pages = Page::all();
    foreach ($pages as $page) {
        if ($page->name === 'Home') {
            Route::get($page->permalink, Home::class)->name($page->name);
        }
        if ($page->name === 'About') {
            Route::get($page->permalink, About::class)->name($page->name);
        }
        if ($page->name === 'Plans') {
            Route::get($page->permalink, Plans::class)->name($page->name);
        }
        if ($page->name === 'Faq') {
            Route::get($page->permalink, Faq::class)->name($page->name);
        }
        if ($page->name === 'Contact') {
            Route::get($page->permalink, Contact::class)->name($page->name);
        }
        if ($page->name === 'Terms') {
            Route::get($page->permalink, Terms::class)->name($page->name);
        }
        if ($page->name === 'Privacy') {
            Route::get($page->permalink, Terms::class)->name($page->name);
        }
        if ($page->name === 'Risk') {
            Route::get($page->permalink, Terms::class)->name($page->name);
        }
    }
});
