<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DarkModeController;
use App\Http\Controllers\ColorSchemeController;
use App\Http\Controllers\DataBahanController;
use App\Http\Controllers\BahanMasukController;
use App\Http\Controllers\RegistrationController;

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

Route::get('dark-mode-switcher', [DarkModeController::class, 'switch'])->name('dark-mode-switcher');
Route::get('color-scheme-switcher/{color_scheme}', [ColorSchemeController::class, 'switch'])->name('color-scheme-switcher');

// Route::middleware('loggedin')->group(function () {
//     Route::get('login', [AuthController::class, 'loginView'])->name('login.index');
//     Route::post('login', [AuthController::class, 'login'])->name('login.check');
//     Route::get('register', [AuthController::class, 'registerView'])->name('register.index');
//     Route::post('register', [AuthController::class, 'register'])->name('register.store');
// });

// yang ini soalnya buat route yang bisa diakses tanpa login
Route::middleware('guest')->group(function () {
    // Register
    Route::get('register', [AuthController::class, 'registerView'])->name('register.index');
    Route::post('register', [AuthController::class, 'register'])->name('register.store');
    // Login
    Route::get('logout', [RegistrationController::class, 'logout']);
    Route::get('/', [RegistrationController::class, 'logout']);
    Route::get('login', [AuthController::class, 'loginView'])->name('login.index');
    // Route::post('login', [AuthController::class, 'login'])->name('login.check');
    Route::post('login', [RegistrationController::class, 'loginStore'])->name('login');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('dashboard', function () {
        return view('dashboard', ['tittle' => 'Dashboard', 'judul' => 'Dashboard', 'menu' => 'Dashboard', 'submenu' => 'Dashboard']);
    });
    // logout
    Route::post('logout', [RegistrationController::class, 'logout'])->name('logout');
    // mengarah ke setiap controller
    Route::resource('dataBahan', DataBahanController::class);
    Route::resource('bahanMasuk', BahanMasukController::class);
    // Route::resource('bahanKeluar', BahanKeluarController::class);
    // Route::resource('satuan', SatuanController::class);
    // Route::resource('produkJadi', ProdukJadiController::class);
    // Route::resource('resep', ResepController::class);
    // Route::resource('sopir', SopirController::class);
    // Route::resource('mobil', MobilController::class);
    // Route::resource('jabatan', JabatanController::class);
    // Route::resource('karyawan', KaryawanController::class);
    // Route::resource('produkMasuk', ProdukMasukController::class);
    // Route::resource('produkKeluar', ProdukKeluarController::class);
    // END Route Projek Kita
    Route::get('/', [PageController::class, 'dashboardOverview1'])->name('dashboard-overview-1');
    Route::get('dashboard-overview-2-page', [PageController::class, 'dashboardOverview2'])->name('dashboard-overview-2');
    Route::get('dashboard-overview-3-page', [PageController::class, 'dashboardOverview3'])->name('dashboard-overview-3');
    Route::get('inbox-page', [PageController::class, 'inbox'])->name('inbox');
    Route::get('file-manager-page', [PageController::class, 'fileManager'])->name('file-manager');
    Route::get('point-of-sale-page', [PageController::class, 'pointOfSale'])->name('point-of-sale');
    Route::get('chat-page', [PageController::class, 'chat'])->name('chat');
    Route::get('post-page', [PageController::class, 'post'])->name('post');
    Route::get('calendar-page', [PageController::class, 'calendar'])->name('calendar');

    // // Data Bahan
    Route::get('databahan', [DataBahanController::class, 'index'])->name('dataBahan');
    Route::resource('dataBahan', DataBahanController::class);

    // // Data Bahan Masuk
    Route::get('bahanmasuk', [BahanMasukController::class, 'index'])->name('bahanMasuk');
    Route::resource('bahanMasuk', BahanMasukController::class);




    Route::get('crud-form-page', [PageController::class, 'crudForm'])->name('crud-form');
    Route::get('users-layout-1-page', [PageController::class, 'usersLayout1'])->name('users-layout-1');
    Route::get('users-layout-2-page', [PageController::class, 'usersLayout2'])->name('users-layout-2');
    Route::get('users-layout-3-page', [PageController::class, 'usersLayout3'])->name('users-layout-3');
    Route::get('profile-overview-1-page', [PageController::class, 'profileOverview1'])->name('profile-overview-1');
    Route::get('profile-overview-2-page', [PageController::class, 'profileOverview2'])->name('profile-overview-2');
    Route::get('profile-overview-3-page', [PageController::class, 'profileOverview3'])->name('profile-overview-3');
    Route::get('wizard-layout-1-page', [PageController::class, 'wizardLayout1'])->name('wizard-layout-1');
    Route::get('wizard-layout-2-page', [PageController::class, 'wizardLayout2'])->name('wizard-layout-2');
    Route::get('wizard-layout-3-page', [PageController::class, 'wizardLayout3'])->name('wizard-layout-3');
    Route::get('blog-layout-1-page', [PageController::class, 'blogLayout1'])->name('blog-layout-1');
    Route::get('blog-layout-2-page', [PageController::class, 'blogLayout2'])->name('blog-layout-2');
    Route::get('blog-layout-3-page', [PageController::class, 'blogLayout3'])->name('blog-layout-3');
    Route::get('pricing-layout-1-page', [PageController::class, 'pricingLayout1'])->name('pricing-layout-1');
    Route::get('pricing-layout-2-page', [PageController::class, 'pricingLayout2'])->name('pricing-layout-2');
    Route::get('invoice-layout-1-page', [PageController::class, 'invoiceLayout1'])->name('invoice-layout-1');
    Route::get('invoice-layout-2-page', [PageController::class, 'invoiceLayout2'])->name('invoice-layout-2');
    Route::get('faq-layout-1-page', [PageController::class, 'faqLayout1'])->name('faq-layout-1');
    Route::get('faq-layout-2-page', [PageController::class, 'faqLayout2'])->name('faq-layout-2');
    Route::get('faq-layout-3-page', [PageController::class, 'faqLayout3'])->name('faq-layout-3');
    Route::get('login-page', [PageController::class, 'login'])->name('login');
    Route::get('register-page', [PageController::class, 'register'])->name('register');
    Route::get('error-page-page', [PageController::class, 'errorPage'])->name('error-page');
    Route::get('update-profile-page', [PageController::class, 'updateProfile'])->name('update-profile');
    Route::get('change-password-page', [PageController::class, 'changePassword'])->name('change-password');
    Route::get('regular-table-page', [PageController::class, 'regularTable'])->name('regular-table');
    Route::get('tabulator-page', [PageController::class, 'tabulator'])->name('tabulator');
    Route::get('modal-page', [PageController::class, 'modal'])->name('modal');
    Route::get('slide-over-page', [PageController::class, 'slideOver'])->name('slide-over');
    Route::get('notification-page', [PageController::class, 'notification'])->name('notification');
    Route::get('accordion-page', [PageController::class, 'accordion'])->name('accordion');
    Route::get('button-page', [PageController::class, 'button'])->name('button');
    Route::get('alert-page', [PageController::class, 'alert'])->name('alert');
    Route::get('progress-bar-page', [PageController::class, 'progressBar'])->name('progress-bar');
    Route::get('tooltip-page', [PageController::class, 'tooltip'])->name('tooltip');
    Route::get('dropdown-page', [PageController::class, 'dropdown'])->name('dropdown');
    Route::get('typography-page', [PageController::class, 'typography'])->name('typography');
    Route::get('icon-page', [PageController::class, 'icon'])->name('icon');
    Route::get('loading-icon-page', [PageController::class, 'loadingIcon'])->name('loading-icon');
    Route::get('regular-form-page', [PageController::class, 'regularForm'])->name('regular-form');
    Route::get('datepicker-page', [PageController::class, 'datepicker'])->name('datepicker');
    Route::get('tom-select-page', [PageController::class, 'tomSelect'])->name('tom-select');
    Route::get('file-upload-page', [PageController::class, 'fileUpload'])->name('file-upload');
    Route::get('wysiwyg-editor-classic', [PageController::class, 'wysiwygEditorClassic'])->name('wysiwyg-editor-classic');
    Route::get('wysiwyg-editor-inline', [PageController::class, 'wysiwygEditorInline'])->name('wysiwyg-editor-inline');
    Route::get('wysiwyg-editor-balloon', [PageController::class, 'wysiwygEditorBalloon'])->name('wysiwyg-editor-balloon');
    Route::get('wysiwyg-editor-balloon-block', [PageController::class, 'wysiwygEditorBalloonBlock'])->name('wysiwyg-editor-balloon-block');
    Route::get('wysiwyg-editor-document', [PageController::class, 'wysiwygEditorDocument'])->name('wysiwyg-editor-document');
    Route::get('validation-page', [PageController::class, 'validation'])->name('validation');
    Route::get('chart-page', [PageController::class, 'chart'])->name('chart');
    Route::get('slider-page', [PageController::class, 'slider'])->name('slider');
    Route::get('image-zoom-page', [PageController::class, 'imageZoom'])->name('image-zoom');
});
