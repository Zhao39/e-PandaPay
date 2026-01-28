<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\ActionController;
use App\Http\Controllers\User\SaveCardPayment;
use App\Http\Controllers\User\SocialLoginController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\EnsureIsUser;
use App\Livewire\User\AccountSettings\Show as AccountSettingsShow;
use App\Livewire\User\ContactSupport;
use App\Livewire\User\CopyTrade\AccountDetails;
use App\Livewire\User\CopyTrade\MasterAccounts;
use App\Livewire\User\CopyTrade\Show;
use App\Livewire\User\CopyTrade\SubAccountInfo;
use App\Livewire\User\CryptoSwapping\Assets;
use App\Livewire\User\CryptoSwapping\Conversion;
use App\Livewire\User\CryptoSwapping\Transactions as CryptoSwappingTransactions;
use App\Livewire\User\CryptoSwapping\ViewCoin;
use App\Livewire\User\Dashboard;
use App\Livewire\User\Deposit\MakePayment;
use App\Livewire\User\Deposit\StartDeposit;
use App\Livewire\User\FundTransfer;
use App\Livewire\User\InvestmentPlan\BuyAPlan;
use App\Livewire\User\InvestmentPlan\MyPlans;
use App\Livewire\User\InvestmentPlan\PlanDetails;
use App\Livewire\User\Kyc\Form;
use App\Livewire\User\Kyc\Info;
use App\Livewire\User\Membership\CourseDetails;
use App\Livewire\User\Membership\Courses;
use App\Livewire\User\Membership\MyCourseDetails;
use App\Livewire\User\Membership\MyCourses;
use App\Livewire\User\Membership\WatchLesson;
use App\Livewire\User\Referral;
use App\Livewire\User\TradeSignal\Index;
use App\Livewire\User\Transactions\Deposit;
use App\Livewire\User\Transactions\Others;
use App\Livewire\User\Transactions\Withdrawal;
use App\Livewire\User\Withdrawal\ChooseWithdrawMethod;
use Illuminate\Support\Facades\Route;

Route::get('/auth/{social}/redirect', [SocialLoginController::class, 'redirect'])->where('social', 'twitter|facebook|linkedin|google|github|bitbucket')->name('social.redirect');
Route::get('/auth/{social}/callback', [SocialLoginController::class, 'authenticate'])->where('social', 'twitter|facebook|linkedin|google|github|bitbucket')->name('social.callback');

Route::get('/ref/{id}', [Controller::class, 'ref'])->name('ref');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    EnsureIsUser::class,
])->group(function () {
    Route::prefix('user')->name('user.')->group(function () {
        Route::middleware('complete.kyc')->group(function () {
            Route::get('dashboard', Dashboard::class)->name('dashboard');
            Route::prefix('deposit')->name('deposit.')->middleware('can:make deposit')->group(function () {
                Route::get('', StartDeposit::class)->name('make');
                Route::post('submitpayment', [UserController::class, 'submitPayment'])->name('submitpayment');
                Route::get('make-payment/method/{method}', MakePayment::class)->name('makepayment');
                Route::post('save-stripe-payment', SaveCardPayment::class)->name('savestripepayment');
                Route::get('paypal-success-transaction', [ActionController::class, 'paypalSuccessTransaction'])->name('paypalSuccessTransaction');
                Route::get('paypla-cancel-transaction', [ActionController::class, 'paypalCancelTransaction'])->name('paypalCancelTransaction');
                // binance crypto payments routes
                Route::get('/binance/success', [ActionController::class, 'binanceSuccess'])->name('bsuccess');
                Route::get('/binance/error', [ActionController::class, 'binanceError'])->name('berror');
                // paystack callback urls sucess and cancel
                Route::get('/paystack-success', [ActionController::class, 'paystackSuccess'])->name('psuccess');
                Route::get('/paystack-cancel', [ActionController::class, 'paystackCancel'])->name('pcancel');
                // flutterwave callback
                Route::get('/rave/callback', [ActionController::class, 'raveCallback'])->name('ravcallback');

                Route::get('coinbase-callback', [ActionController::class, 'coinbaseCallback'])->name('coinbaseCallback');
            });

            Route::get('withdraw/request', ChooseWithdrawMethod::class)->name('withdraw.request')->middleware('can:make withdrawal');

            Route::prefix('transactions')->name('transactions.')->middleware('can:see their transactions history')->group(function () {
                Route::get('deposit', Deposit::class)->name('deposit');
                Route::get('withdrawal', Withdrawal::class)->name('withdrawal');
                Route::get('others', Others::class)->name('others');
            });

            Route::get('transfer-fund', FundTransfer::class)->name('transferfund');

            Route::prefix('investment')->name('investment.')->group(function () {
                Route::get('buy-plan', BuyAPlan::class)->name('buyplan')->middleware('can:purchase plan');
                Route::get('my-plans', MyPlans::class)->name('myplans')->middleware('can:see their plans');
                Route::get('plan/{plan}/details', PlanDetails::class)->middleware('can:see their plans')->name('plandetails');
            });
            Route::prefix('crypto-swap')->name('swap.')->group(function () {
                Route::get('assets', Assets::class)->name('assets');
                Route::get('transactions', CryptoSwappingTransactions::class)->name('transactions');
                Route::get('coin/{coin:symbol}', ViewCoin::class)->name('viewcoin');
                Route::get('convert/{coin:symbol}', Conversion::class)->name('convert');
            });

            Route::get('referral', Referral::class)->name('referral')->middleware('can:refer users');

            Route::get('trade-signals/{page}', Index::class)->name('tradeSignals');

            Route::prefix('copier')->name('copier.')->group(function () {
                Route::get('home', Show::class)->name('show');
                Route::get('master-accounts', MasterAccounts::class)->name('masters');
                Route::get('master-accounts/{login}', AccountDetails::class)->name('master.details');
                Route::get('account-info/{account}', SubAccountInfo::class)->name('account.info');
            });

            Route::prefix('membership')->name('membership.')->group(function () {
                Route::get('courses/{page}', Courses::class)->name('courses');
                Route::get('course-details/{course}/{id}', CourseDetails::class)->name('course.details');
                Route::get('my-courses', MyCourses::class)->name('mycourses');
                Route::get('my-course-details/{id}', MyCourseDetails::class)->name('mycoursedetails');
                Route::get('learning/lesson/{lesson}/course/{course?}', WatchLesson::class)->name('learning');
            });

            Route::get('account-settings', AccountSettingsShow::class)->name('profile.show');
        });

        Route::get('contact-support', ContactSupport::class)->name('contactsupport')->middleware('can:contact support');
        Route::prefix('kyc')->name('kyc.')->group(function () {
            Route::get('start', Info::class)->name('start');
            Route::get('submit', Form::class)->name('form');
            Route::post('submit', [UserController::class, 'submitKyc'])->name('submit');
        });
    });
});