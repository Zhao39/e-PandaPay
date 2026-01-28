<?php

use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\SetupController;
use App\Http\Controllers\Admin\SignalController;
use App\Http\Controllers\Controller;
use App\Http\Middleware\AdminRedirectIfAuthenticated;
use App\Http\Middleware\AdminRedirectIfPassTwofactor;
use App\Http\Middleware\AuthenticateAdmin;
use App\Http\Middleware\EnsureAdminPassTwoFactorAuth;
use App\Http\Middleware\EnsureIsAdmin;
use App\Livewire\Admin\AccountSettings;
use App\Livewire\Admin\Auth\ForgotPassword;
use App\Livewire\Admin\Auth\Login;
use App\Livewire\Admin\Auth\ResetPassword;
use App\Livewire\Admin\Auth\Twofactor;
use App\Livewire\Admin\CopyTrade\ProvidersAccount;
use App\Livewire\Admin\CopyTrade\Settings;
use App\Livewire\Admin\CopyTrade\SubscribersAccount;
use App\Livewire\Admin\CopyTrade\SymbolMap;
use App\Livewire\Admin\Crm\EmailServices;
use App\Livewire\Admin\Crm\Tasks;
use App\Livewire\Admin\CryptoSwap\ManageAssets;
use App\Livewire\Admin\CryptoSwap\SwapSettings;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\InvestmentPlan\Plans;
use App\Livewire\Admin\InvestmentPlan\ProfitRecord;
use App\Livewire\Admin\InvestmentPlan\UsersPlans;
use App\Livewire\Admin\Kyc\Applications;
use App\Livewire\Admin\Kyc\SingleApplication;
use App\Livewire\Admin\ManageDeposits\Records;
use App\Livewire\Admin\ManageUsers\CreateNewUser;
use App\Livewire\Admin\ManageUsers\ListUsers;
use App\Livewire\Admin\ManageUsers\SingleUser;
use App\Livewire\Admin\Membership\Categories;
use App\Livewire\Admin\Membership\CourseLessons;
use App\Livewire\Admin\Membership\Courses;
use App\Livewire\Admin\Membership\LessonsWithoutCourses;
use App\Livewire\Admin\PlatformAdministration\ActivitiesLog;
use App\Livewire\Admin\PlatformAdministration\Administrators\ListAdmins;
use App\Livewire\Admin\PlatformAdministration\CacheManagement;
use App\Livewire\Admin\PlatformAdministration\CronJob;
use App\Livewire\Admin\PlatformAdministration\Roles\ListRoles;
use App\Livewire\Admin\PlatformAdministration\ShowAll;
use App\Livewire\Admin\PlatformAdministration\SystemCleanUp;
use App\Livewire\Admin\PlatformAdministration\SystemInformation;
use App\Livewire\Admin\PlatformAdministration\SystemUpdater;
use App\Livewire\Admin\Settings\AllSettings;
use App\Livewire\Admin\Settings\Bonus\OtherBonus;
use App\Livewire\Admin\Settings\Bonus\ReferralBonus;
use App\Livewire\Admin\Settings\DashboardAppearance;
use App\Livewire\Admin\Settings\EmailSettings;
use App\Livewire\Admin\Settings\EmailTemplateEdit;
use App\Livewire\Admin\Settings\EmailTemplates;
use App\Livewire\Admin\Settings\GeneralSettings;
use App\Livewire\Admin\Settings\ModulesSettings;
use App\Livewire\Admin\Settings\Others\Communication;
use App\Livewire\Admin\Settings\Others\ControlCenter;
use App\Livewire\Admin\Settings\Others\SocialLogin;
use App\Livewire\Admin\Settings\Payment\BinanceApi;
use App\Livewire\Admin\Settings\Payment\Coinbase;
use App\Livewire\Admin\Settings\Payment\CoinpaymentApi;
use App\Livewire\Admin\Settings\Payment\FlutterwaveApi;
use App\Livewire\Admin\Settings\Payment\FundsTransfer;
use App\Livewire\Admin\Settings\Payment\PaymentMethods;
use App\Livewire\Admin\Settings\Payment\PaymentPreference;
use App\Livewire\Admin\Settings\Payment\PaypalApi;
use App\Livewire\Admin\Settings\Payment\PaystackApi;
use App\Livewire\Admin\Settings\Payment\StripeApi;
use App\Livewire\Admin\Settings\SitePreference;
use App\Livewire\Admin\Settings\Website\Faqs;
use App\Livewire\Admin\Settings\Website\IPAddress;
use App\Livewire\Admin\Settings\Website\Media;
use App\Livewire\Admin\Settings\Website\Testimony;
use App\Livewire\Admin\Settings\Website\Web\Contents;
use App\Livewire\Admin\Settings\Website\Web\Pages;
use App\Livewire\Admin\Settings\Website\WebSettings;
use App\Livewire\Admin\SignalProvider\Signals;
use App\Livewire\Admin\SignalProvider\SignalSettings;
use App\Livewire\Admin\SignalProvider\SignalSubscribers;
use App\Livewire\Admin\Transactions;
use App\Livewire\Admin\Withdrawal\ManageWithdrawal;
use App\Models\Settings as ModelsSettings;
use Illuminate\Support\Facades\Route;

Route::name('admin.')->group(function () {
    $adminBaseUrl = ModelsSettings::select('admin_base_url')->find(1)->admin_base_url ?? '/admin';
    Route::prefix($adminBaseUrl)->group(function () {
        Route::name('auth.')->middleware([AdminRedirectIfAuthenticated::class])->group(function () {
            Route::get('login', Login::class)->name('login');
            Route::get('forgot-password', ForgotPassword::class)->name('forgotPassword');
            Route::get('reset-password/{email}', ResetPassword::class)->name('resetPassword');
        });
        Route::get('two-factor', Twofactor::class)->name('twoFactor')->middleware(AdminRedirectIfPassTwofactor::class);
        Route::middleware([AuthenticateAdmin::class, EnsureIsAdmin::class, EnsureAdminPassTwoFactorAuth::class])->group(function () {
            Route::post('logout', [Controller::class, 'logout'])->name('logout');
            Route::get('dashboard', Dashboard::class)->name('dashboard');
            Route::get('account-settings', AccountSettings::class)->name('accountSettings')->middleware(['can:admin update account settings']);
            Route::get('manage-deposits', Records::class)->name('manageDeposits')->middleware(['can:view deposits']);
            Route::get('manage-withdrawals', ManageWithdrawal::class)->name('manageWithdrawal')->middleware(['can:view withdrawals']);
            Route::get('plans', Plans::class)->name('investmentPlans')->middleware(['can:view investment plan']);
            Route::get('users-plans', UsersPlans::class)->name('usersPlans')->middleware(['can:view users plan']);
            Route::get('user-plan/{userPlan}/profit-history', ProfitRecord::class)->name('profitHistory')->middleware(['can:see users plan profit history']);

            Route::get('kyc-applications', Applications::class)->name('kycApplications')->middleware(['can:view kyc applications']);
            Route::get('process-application/{kyc}', SingleApplication::class)->name('processKycApplication')->middleware(['can:process kyc applications']);

            Route::prefix('platform-administration')->name('platform.')->group(function () {
                Route::get('/', ShowAll::class)->name('index')->middleware(['can:view platform administration']);
                Route::get('/roles-permissions', ListRoles::class)->name('roles')->middleware(['can:update roles & permissions']);
                Route::get('system-admin', ListAdmins::class)->name('admins')->middleware(['can:see administrators']);
                Route::get('activities-log', ActivitiesLog::class)->name('activitiesLog')->middleware(['can:view activty log']);
                Route::get('cron-job', CronJob::class)->name('cron')->middleware(['can:view cronjob']);
                Route::get('system-clean-up', SystemCleanUp::class)->name('cleanUp')->middleware(['can:perform system cleanup']);
                Route::get('clear-cache', CacheManagement::class)->name('clearcache')->middleware(['can:clear cache']);
                Route::get('system-information', SystemInformation::class)->name('systemInfo')->middleware(['can:view system info']);
                Route::get('system-update', SystemUpdater::class)->name('systemUpdate')->middleware(['can:perform system update']);
            });

            Route::get('users-transactions', Transactions::class)->name('usersTransactions')->middleware(['can:view transactions']);

            Route::prefix('crm')->name('crm.')->group(function () {
                Route::get('tasks', Tasks::class)->name('tasks')->middleware(['can:view tasks assigned to them']);
                Route::get('send-email', EmailServices::class)->name('sendMail')->middleware(['can:send emails']);
            });

            Route::prefix('copytrade')->name('copytrading.')->middleware(['can:see copytrade menu'])->group(function () {
                Route::get('settings', Settings::class)->name('settings')->middleware(['can:manage copytrade settings']);
                Route::get('manage-providers', ProvidersAccount::class)->name('providers')->middleware(['can:view providers']);
                Route::get('manage-subscribers', SubscribersAccount::class)->name('subscribers')->middleware(['can:manage subscribers']);
                Route::get('symbolmaps', SymbolMap::class)->name('symbolmaps')->middleware(['can:view symbolmaps']);
            });

            Route::prefix('membership')->name('membership.')->middleware(['can:see membership menu'])->group(function () {
                Route::get('categories', Categories::class)->name('categories')->middleware(['can:manage categories']);
                Route::get('courses/page/{page}', Courses::class)->name('courses')->middleware(['can:manage courses']);
                Route::get('lessons', LessonsWithoutCourses::class)->name('lessons')->middleware(['can:manage lessons']);
                Route::get('course/{id}/lessons/page/{page}', CourseLessons::class)->name('courseLessons')->middleware(['can:manage lessons']);

                Route::controller(MembershipController::class)->middleware(['can:manage courses'])->group(function () {
                    Route::post('add-course', 'addCourse')->name('addCourse');
                    Route::patch('edit-course', 'editCourse')->name('editCourse');
                    Route::delete('delete-course/{id}', 'deleteCourse')->name('deleteCourse');
                });

                Route::controller(MembershipController::class)->middleware(['can:manage lessons'])->group(function () {
                    Route::post('add-lesson', 'addLesson')->name('addlesson');
                    Route::patch('update-lesson', 'updateLesson')->name('updatelesson');
                    Route::delete('delete-lesson/{id}/{course_id?}', 'deleteLesson')->name('deletelesson');
                });
            });

            Route::prefix('signal')->name('signal.')->middleware(['can:see signal menu'])->group(function () {
                Route::get('list/page/{page}', Signals::class)->name('signals')->middleware(['can:manage signals']);
                Route::get('settings', SignalSettings::class)->name('settings')->middleware(['can:manage signal settings']);
                Route::get('subscribers/page/{page}', SignalSubscribers::class)->name('subscribers')->middleware(['can:manage signal subscribers']);
                Route::post('save-analysis', [SignalController::class, 'saveAnalysis'])->name('saveAnalysis');
            });

            Route::prefix('swap')->name('swap.')->middleware(['can:see crypto swap menu'])->group(function () {
                Route::get('manage-assets', ManageAssets::class)->name('assets')->middleware(['can:manage assets']);
                Route::get('settings', SwapSettings::class)->name('settings')->middleware(['can:manage swap settings']);
            });

            Route::prefix('users')->name('users.')->group(function () {
                Route::get('add', CreateNewUser::class)->name('add')->middleware(['can:create user']);
                Route::get('', ListUsers::class)->name('listUsers')->middleware(['can:view users']);
                Route::get('{user}', SingleUser::class)->name('singleUser')->middleware(['can:edit user']);
            });

            Route::prefix('settings')->name('settings.')->middleware(['can:view settings'])->group(function () {
                Route::get('/', AllSettings::class)->name('index');
                Route::get('general', GeneralSettings::class)->name('general')->middleware(['can:update general settings']);
                Route::patch('update-general', [SetupController::class, 'updateGeneralSettings'])->name('updateGeneralSettings')->middleware(['can:update general settings']);
                Route::get('email', EmailSettings::class)->name('email')->middleware(['can:update email settings']);
                Route::get('email-templates', EmailTemplates::class)->name('emailTemplates')->middleware(['can:update email templates']);
                Route::get('email-templates/{template:name}', EmailTemplateEdit::class)->name('editTemplate')->middleware(['can:update email templates']);
                Route::get('site-preference', SitePreference::class)->name('sitePreference')->middleware(['can:update preference']);
                Route::get('appearance', DashboardAppearance::class)->name('appearance')->middleware(['can:update dashboard appearance']);
                Route::get('modules', ModulesSettings::class)->name('modules')->middleware(['can:update modules settings']);
                Route::prefix('payment')->name('payment.')->middleware(['can:view payment methods'])->group(function () {
                    Route::get('methods', PaymentMethods::class)->name('methods');
                    Route::post('add-method', [SetupController::class, 'addPaymentMethod'])->name('addMethod');
                    Route::patch('edit-method', [SetupController::class, 'editPaymentMethod'])->name('editMethod');
                    Route::get('preference', PaymentPreference::class)->name('preference')->middleware(['can:update payment preference']);
                    Route::get('coinpayment-settings', CoinpaymentApi::class)->name('coinpayment')->middleware(['can:update coinpayment settings']);
                    Route::get('stripe-settings', StripeApi::class)->name('stripe')->middleware(['can:update stripe settings']);
                    Route::get('paypal-settings', PaypalApi::class)->name('paypal')->middleware(['can:update paypal settings']);
                    Route::get('paystack-settings', PaystackApi::class)->name('paystack')->middleware(['can:update paystack settings']);
                    Route::get('flutterwave-settings', FlutterwaveApi::class)->name('flutterwave')->middleware(['can:update flutterwave settings']);
                    Route::get('binance-settings', BinanceApi::class)->name('binance')->middleware(['can:update binance settings']);
                    Route::get('coinbase-settings', Coinbase::class)->name('coinbase')->middleware(['can:update coinbase settings']);
                    Route::get('transfer-settings', FundsTransfer::class)->name('transfer')->middleware(['can:update fund transfer settings']);
                });
                Route::prefix('bonus')->name('bonus.')->middleware(['can:update ref & other bonuses'])->group(function () {
                    Route::get('referral-bonus', ReferralBonus::class)->name('ref');
                    Route::get('other-bonus', OtherBonus::class)->name('others');
                });
                Route::get('social-login', SocialLogin::class)->name('socialLogin')->middleware(['can:update social login settings']);
                Route::get('communication', Communication::class)->name('communication')->middleware(['can:update communication settings']);
                Route::get('control-center', ControlCenter::class)->name('center')->middleware(['can:update control center']);

                Route::prefix('website')->name('website.')->middleware(['can:update website settings'])->group(function () {
                    Route::get('faqs', Faqs::class)->name('faqs');
                    Route::get('testimonies', Testimony::class)->name('testimonies');
                    Route::get('media', Media::class)->name('media');
                    Route::post('add-media', [SetupController::class, 'addMedia'])->name('addMedia');
                    Route::get('ip-address', IPAddress::class)->name('ipaddress');
                    Route::get('pages', Pages::class)->name('pages');
                    Route::get('pages/{page}/content', Contents::class)->name('contents');
                    Route::get('settings', WebSettings::class)->name('settings');
                    Route::post('save-content', [Controller::class, 'saveContent'])->name('saveContent');
                });
            });
        });
    });
});
