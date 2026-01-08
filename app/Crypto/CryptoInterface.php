<?php

namespace App\Crypto;

use App\Crypto\Brokers\Bingx;
use App\Crypto\Brokers\Coinex;
use App\Crypto\Brokers\Kucoin;
use App\Crypto\Brokers\Wallex;
use App\Http\Controllers\Crypto\kucoin as CryptoKucoin;
use Illuminate\View\DynamicComponent;

class CryptoInterface extends DynamicComponent
{
    private $brokerName;
    private $broker;
    private $UserName;
    private $ActiveClass;

    public function __construct($broker, $UserName)
    {
        $this->brokerName = $broker;
        $this->UserName = $UserName;
        $broker = strtolower($broker);
        switch ($broker) {
            case 'kucoin':
                $this->broker = new Kucoin();
                $this->ActiveClass =  [
                    'result' => true
                ];
                break;
            case 'coinex':
                $this->broker = new Coinex();
                $this->ActiveClass =  [
                    'result' => true
                ];
                break;
            case 'bingx':
                $this->broker = new Bingx();
                $this->ActiveClass =  [
                    'result' => true
                ];
                break;
            case 'wallex':
                $this->broker = new Wallex();
                $this->ActiveClass =  [
                    'result' => true
                ];
                break;
            default:
                $this->ActiveClass =  [
                    'result' => false,
                    'msg' => 'The broker is not define'
                ];
                break;
        }
    }
    public function get_all_tickers()
    {
        if (!$this->ActiveClass['result']) {
            return $this->ActiveClass;
        }
        return $this->broker->get_all_tickers();
    }
}
