<?php

namespace App\Crypto;

use App\Models\crypto_price_15ms;
use App\Models\crypto_price_1hs;
use App\Models\crypto_price_30ms;
use App\Models\crypto_price_5ms;
use Psy\Command\WhereamiCommand;
use Ramsey\Uuid\Type\Integer;

class TradersFunctions
{
    public function price_scaling(string $input_price,  $multiple_position = null)
    {
        if ($multiple_position == null) { // find suitable position to scale number
            $Counter = 0;
            while ($input_price < 10) {
                $input_price *= 10;
                $Counter++;
            }
            return [
                'result' => $input_price,
                'position' => $Counter
            ];
        } else {
            for ($i = 0; $i < $multiple_position; $i++) {
                $input_price *= 10;
            }
            return [
                'result' => $input_price,
                'position' => $multiple_position
            ];
        }
    }
    private function symbol_validation($symbol)
    {
        $symbol =  str_replace('-USDT', '', $symbol);
        $symbol .= '-USDT';
        return $symbol;
    }
    private function get_price_src($Currency, $MaxTimePeriod, $DataSrc = '5m')
    {
        $Currency = $this->symbol_validation($Currency);
        if ($DataSrc == '5m') {
            $PriceArrSrc = crypto_price_5ms::where('curency', $Currency)->orderBy('candate', 'DESC')->limit($MaxTimePeriod)->get();
        } elseif ($DataSrc == '15m') {
            $PriceArrSrc = crypto_price_15ms::where('curency', $Currency)->orderBy('candate', 'DESC')->limit($MaxTimePeriod)->get();
        } elseif ($DataSrc == '30m') {
            $PriceArrSrc = crypto_price_30ms::where('curency', $Currency)->orderBy('candate', 'DESC')->limit($MaxTimePeriod)->get();
        } elseif ($DataSrc == '1h') {
            $PriceArrSrc = crypto_price_1hs::where('curency', $Currency)->orderBy('candate', 'DESC')->limit($MaxTimePeriod)->get();
        }
        return $PriceArrSrc;
    }

    /**
     * The `SMA_indicator` function calculates the Simple Moving Average for a given currency and time
     * period.
     * 
     * @param Currency The currency parameter is a string that represents the currency for which you want
     * to calculate the Simple Moving Average (SMA). It is used to filter the data from the
     * crypto_price_5ms table.
     * @param timePeriod The `timePeriod` parameter is an array that contains the time periods for which
     * you want to calculate the Simple Moving Average (SMA). Each element in the array represents a
     * specific time period.
     * 
     * @return an array with calculated data.
     *
     */
    public function SMA_indicator(string $Currency, array $timePeriod)
    {
        //This function calculate Simple Moving Average 
        $MaxTimePeriod = max($timePeriod);
        $PriceArrSrc = $this->get_price_src($Currency, $MaxTimePeriod, '1h');
        $Init = true;
        $Result = [];
        foreach ($timePeriod as $timePeriodItem) {
            $PriceArrRes = array();
            $Counter = 0;
            $Position = 0;
            foreach ($PriceArrSrc as $PriceArrItem) {
                if ($Counter > $timePeriodItem) {
                    break;
                }
                $Counter++;
                if ($Counter == 1 && $Init) {
                    $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice);
                    $Position =  $PriceArr['position'];
                    $Price = $PriceArr['result'];
                    $Init = false;
                } else {
                    $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice, $Position);
                    $Price = $PriceArr['result'];
                }
                array_push($PriceArrRes, $Price);
            }
            try {

                $SMA =  trader_sma($PriceArrRes, $Counter);
            } catch (\Exception $e) {

                return false;
            }


            foreach ($SMA as $SMAT) {
                break;
            }
            $ArrFelid = [
                'SMA' => $SMAT,
                'PeriodItem' => $timePeriodItem
            ];
            array_push($Result, $ArrFelid);
        }
        //Returns an array with calculated dat
        return $Result;
    }



    /**
     * The EMA_indicator function calculates the Exponential Moving Average for a given currency and time
     * period.
     * 
     * @param Currency The currency for which you want to calculate the Exponential Moving Average (EMA).
     * It could be any currency symbol like "USD", "EUR", etc.
     * @param timePeriod An array of integers representing the time periods for which you want to calculate
     * the Exponential Moving Average (EMA).
     * 
     * @return an array with calculated data. Each element in the array contains the Exponential Moving
     * Average (EMA) value and the corresponding time period.
     */
    public function EMA_indicator(string $Currency, array $timePeriod)
    {
        //This function calculate Exponential Moving Average
        $MaxTimePeriod = max($timePeriod);
        $PriceArrSrc = $this->get_price_src($Currency, $MaxTimePeriod);
        $Init = true;
        $Result = [];
        foreach ($timePeriod as $timePeriodItem) {
            $PriceArrRes = array();
            $Counter = 0;
            $Position = 0;
            foreach ($PriceArrSrc as $PriceArrItem) {
                if ($Counter > $timePeriodItem) {
                    break;
                }
                $Counter++;
                if ($Counter == 1 && $Init) {
                    $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice);
                    $Position =  $PriceArr['position'];
                    $Price = $PriceArr['result'];
                    $Init = false;
                } else {
                    $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice, $Position);
                    $Price = $PriceArr['result'];
                }
                array_push($PriceArrRes, $Price);
            }
            $EMA =  trader_ema($PriceArrRes, $Counter);
            foreach ($EMA as $EMAT) {
                break;
            }
            $ArrFelid = [
                'EMA' => $EMAT,
                'PeriodItem' => $timePeriodItem
            ];
            array_push($Result, $ArrFelid);
        }
        //Returns an array with calculated data 
        return $Result;
    }

    /**
     * The MACD_indicator function calculates the Moving Average Convergence/Divergence values for a given
     * currency, using the specified periods for the fast, slow, and signal lines.
     * 
     * @param Currency The currency for which you want to calculate the MACD indicator. It is a string
     * parameter.
     * @param fastPeriod The fastPeriod parameter represents the number of periods used to calculate the
     * fast moving average in the MACD indicator. In this code, it is set to a default value of 12.
     * @param slowPeriod The slowPeriod parameter in the MACD_indicator function represents the number of
     * periods used to calculate the slower moving average in the MACD calculation. It is set to a default
     * value of 26 in the function signature.
     * @param signalPeriod The signalPeriod parameter in the MACD_indicator function represents the number
     * of periods used to calculate the signal line in the Moving Average Convergence/Divergence (MACD)
     * indicator. The signal line is a moving average of the MACD line and is used to generate trading
     * signals. By default, 
     *  Smoothing for the signal line (nb of period). Valid range from 1 to 100000.
     * 
     * @return an array of arrays. The first array contains the MACD values, the second array contains the
     * Signal values, and the third array contains the Divergence values.
     */
    public function MACD_indicator(string $Currency, int $fastPeriod = 12, int $slowPeriod = 26, int $signalPeriod = 9)
    {
        //Moving Average Convergence/Divergence
        $Counter = 0;
        $PriceArrRes = [];
        $PriceArrSrc = $this->get_price_src($Currency, $slowPeriod + $signalPeriod - 1);
        foreach ($PriceArrSrc as $PriceArrItem) {
            $Counter++;
            if ($Counter == 1) {
                $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice);
                $Position =  $PriceArr['position'];
                $Price = $PriceArr['result'];
                $Init = false;
            } else {
                $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice, $Position);
                $Price = $PriceArr['result'];
            }
            array_push($PriceArrRes, $Price);
        }
        $MACD = trader_macd($PriceArrRes, $fastPeriod, $slowPeriod, $signalPeriod);
        /**
         * Return value of this function is an array of arrays :
         * index [0]: MACD values
         * index [1]: Signal values
         * index [2]: Divergence values
         */
        return  $MACD;
    }

    /**
     * The function calculates the Relative Strength Index (RSI) for a given currency and time period.
     * 
     * @param Currency The "Currency" parameter is a string that represents the currency for which you want
     * to calculate the Relative Strength Index (RSI). It could be any valid currency symbol, such as
     * "USD", "EUR", "GBP", etc.
     * @param timePeriod The timePeriod parameter represents the number of periods used to calculate the
     * Relative Strength Index (RSI). In this case, it is set to a default value of 14, but you can change
     * it to any positive integer value to adjust the calculation period.
     * 
     * @return the first element of the RSI array calculated using the trader_rsi function.
     */
    public function RSI_indicator(string $Currency, $timePeriod = 14)
    {
        //This function calculate Relative Strength Index 
        $Counter = 0;
        $PriceArrRes = [];
        $PriceArrSrc = $this->get_price_src($Currency, $timePeriod + 1);
        $Position = 0;
        foreach ($PriceArrSrc as $PriceArrItem) {
            $Counter++;
            if ($Counter == 1) {
                $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice);
                $Position =  $PriceArr['position'];
                $Price = $PriceArr['result'];
                $Init = false;
            } else {
                $PriceArr =  $this->price_scaling($PriceArrItem->ClosePrice, $Position);
                $Price = $PriceArr['result'];
            }
            array_push($PriceArrRes, $Price);
        }
        $RSI = trader_rsi($PriceArrRes, $timePeriod);
        if (is_array($RSI)) {
            foreach ($RSI as $RSIItem) {
                break;
            }
            return ($RSIItem);
        } else {
            return 0;
        }
    }
}
