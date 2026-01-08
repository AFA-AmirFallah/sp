<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;



use App\Models\UserInfo;
use App\myappenv;
use Illuminate\Support\Facades\Gate;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('root', function (UserInfo $user) {
            return $user->Role >= myappenv::role_SuperAdmin;
        });
        Gate::define('admin', function (UserInfo $user) {
            return $user->Role >= myappenv::role_admin;
        });
        Gate::define('worker', function (UserInfo $user) {
            return $user->Role >= myappenv::role_worker;
        });
        Gate::define('accounting', function (UserInfo $user) {
            return $user->Role >= myappenv::role_Accounting;
        });
        Gate::define('bank', function (UserInfo $user) {
            return $user->Role >= myappenv::role_Bank;
        });
        Gate::define('customer', function (UserInfo $user) {
            return $user->Role >= myappenv::role_customer;
        });
        Gate::define('hr', function (UserInfo $user) {
            return $user->Role >= myappenv::role_HR;
        });
        Gate::define('shopadmin', function (UserInfo $user) {
            return $user->Role >= myappenv::role_ShopAdmin;
        });
        Gate::define('shopowner', function (UserInfo $user) {
            return $user->Role >= myappenv::role_ShopOwner;
        });
        Gate::define('superviser', function (UserInfo $user) {
            return $user->Role >= myappenv::role_superviser;
        });
        Gate::define('root_', function (UserInfo $user) {
            return $user->Role == myappenv::role_SuperAdmin;
        });
        Gate::define('admin_', function (UserInfo $user) {
            return $user->Role == myappenv::role_admin;
        });
        Gate::define('worker_', function (UserInfo $user) {
            return $user->Role == myappenv::role_worker;
        });
        Gate::define('accounting_', function (UserInfo $user) {
            return $user->Role == myappenv::role_Accounting;
        });
        Gate::define('bank_', function (UserInfo $user) {
            return $user->Role == myappenv::role_Bank;
        });
        Gate::define('customer_', function (UserInfo $user) {
            return $user->Role == myappenv::role_customer;
        });
        Gate::define('hr_', function (UserInfo $user) {
            return $user->Role == myappenv::role_HR;
        });
        Gate::define('shopadmin_', function (UserInfo $user) {
            return $user->Role == myappenv::role_ShopAdmin;
        });
        Gate::define('shopowner_', function (UserInfo $user) {
            return $user->Role == myappenv::role_ShopOwner;
        });
        Gate::define('superviser_', function (UserInfo $user) {
            return $user->Role == myappenv::role_superviser;
        });
        Gate::define('send_custom_sms', function () {
            return  myappenv::Lic['send_custom_sms'];
        });
        Gate::define('wpa', function () {
            return  myappenv::Lic['wpa'];
        });
        Gate::define('MultiBranch', function () {
            return  myappenv::Lic['MultiBranch'];
        });
        Gate::define('hozorgheyab', function () {
            return  myappenv::Lic['hozorgheyab'];
        });
        Gate::define('device', function () {
            return  myappenv::Lic['device'];
        });
        Gate::define('Service', function () {
            return  myappenv::Lic['Service'];
        });
        Gate::define('PersonelCard', function () {
            return  myappenv::Lic['PersonelCard'];
        });
        Gate::define('HCIS_Workflow', function () {
            return  myappenv::Lic['HCIS_Workflow'];
        });
        Gate::define('HCIS', function () {
            return  myappenv::Lic['HCIS'];
        });
        Gate::define('news', function () {
            return  myappenv::Lic['news'];
        });
        Gate::define('Statistics', function () {
            return  myappenv::Lic['Statistics'];
        });
        Gate::define('SMSReciver', function () {
            return  myappenv::Lic['SMSReciver'];
        });
        Gate::define('CustomerUpload', function () {
            return  myappenv::Lic['CustomerUpload'];
        });
        Gate::define('SmartInvoice', function () {
            return  myappenv::Lic['SmartInvoice'];
        });
        Gate::define('moshavereh', function () {
            return  myappenv::Lic['moshavereh'];
        });
        Gate::define('Labs', function () {
            return  myappenv::Lic['Labs'];
        });
        Gate::define('notification', function () {
            return  myappenv::Lic['notification'];
        });
        Gate::define('moshavereh', function () {
            return  myappenv::Lic['moshavereh'];
        });
        Gate::define('woocommerce', function () {
            return  myappenv::Lic['woocommerce'];
        });
        Gate::define('Ticketing', function () {
            return  myappenv::Lic['Ticketing'];
        });
        Gate::define('marketplace', function () {
            return  myappenv::Lic['marketplace'];
        });
        Gate::define('offline', function () {
            return  myappenv::Lic['offline'];
        });
        Gate::define('crawler', function () {
            return  myappenv::Lic['crawler'];
        });
        Gate::define('TavanPardakht', function () {
            return  myappenv::Lic['TavanPardakht'];
        });
        Gate::define('sitemap', function () {
            return  myappenv::Lic['sitemap'];
        });
    }
}
