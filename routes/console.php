<?php

use App\arzonline\arzonline_robot_work;
use App\Functions\NewsClass;
use App\view_counter\View_counter;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Crypto\CryptoFunctions;
use App\Crypto\CryptoRobots;
use App\myappenv;
use App\Functions\CallCenterClass;
use App\Http\Controllers\APIS\SMSSender;
use App\Http\Controllers\crawler\CrawlerMain;
use App\Http\Controllers\woocommerce\product;
use App\voip\Voip_sync;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Artisan::command('trader{req_type}', function () { // kucoin
    $CryptoFunctions = new CryptoRobots;
    $CryptoFunctions->trader_robot_start($this->argument('req_type'));
});
Artisan::command('robat1', function () { // kucoin
    $CryptoFunctions = new CryptoFunctions();
    $CryptoFunctions->RobotExecute();
});
Artisan::command('arzonline', function () { // arzonline
    $robot = new arzonline_robot_work;
    $result = $robot->each_run();
    return $result;
});
Artisan::command('robat2', function () { //coinex 
    $CryptoFunctions = new CryptoFunctions();
    $CryptoFunctions->CoinexTickers();
});
Artisan::command('view_count', function () {  
    $news = new View_counter;
    $updated = $news->aggregate_view_counter();
    echo $updated;
    return $updated;

});
Artisan::command('metacurency', function () {
    $CryptoFunctions = new CryptoFunctions();
    $CryptoFunctions->UpdateMetaCurencys();

});
Artisan::command('freeDB', function () {
    $CryptoFunctions = new CryptoFunctions();
    $CryptoFunctions->freeDB();

});
Artisan::command('MAIndecator', function () {
    $CryptoFunctions = new CryptoFunctions();
    $CryptoFunctions->MAIndecator();
});
Artisan::command('synccall', function () {
    if (myappenv::Lic['Voip']) {
        $callcenter = new CallCenterClass();
        return $callcenter->synccalls();
    }
});
Artisan::command('syncmelliids', function () {
    if (myappenv::Lic['Voip']) {
        $user = new SMSSender();
        return $user->MainSend();
    }
});
Artisan::command('financial', function () {
    $Product = new product;
});
Artisan::command('rayan_reader', function () {
    $mysite = new CrawlerMain;
    return $mysite->rayan_reader();
});
Artisan::command('crawler_check', function () {
    $mysite = new CrawlerMain;
    return $mysite->price_review();
});
Artisan::command('voip_sync', function () {
    $my_voip = new Voip_sync;
    return $my_voip->sync_with_voip_server();
    ;
});
