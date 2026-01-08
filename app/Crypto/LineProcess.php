<?php

namespace App\Crypto;

use DB;

class LineProcess
{
    private $Curency;
    private $CandeleSrc;
    private $CandeleCounts;
    private $Devesion = 5;
    function __construct($Curency)
    {
        $this->Curency = $Curency;
        $Query = "SELECT * FROM crypto_price_1hs WHERE curency = '$Curency' ORDER BY crypto_price_1hs.candate ASC , canh ASC";
        $this->CandeleSrc = DB::select($Query);
        $this->CandeleCounts = count($this->CandeleSrc);
    }
    private function ProcessCandeles()
    {
        $Devisions = number_format(floor($this->CandeleCounts / $this->Devesion));
        $Conter = 0;
        $IndexItem = 0;
        $Percent = 0;
        $NegPercent = 0;
        $PosPercent = 0;
        $Lines = array();
        foreach ($this->CandeleSrc as $Candele) {
            if ($Conter < $Devisions) {
                $HighPrice = $Candele->HighPrice;
                $LowPrice = $Candele->LowPrice;
                $Percent += $Candele->Percent;
                if ($Candele->Percent > 0) {
                    $PosPercent += $Candele->Percent;
                } else {
                    $NegPercent += $Candele->Percent;
                }
                if (isset($Lines[$IndexItem]['max1'])) {
                    if ($HighPrice > $Lines[$IndexItem]['max1']) {
                        $Lines[$IndexItem]['max1'] = $HighPrice;
                        $Lines[$IndexItem]['max1pos'] = $Conter;
                    } elseif ($HighPrice > $Lines[$IndexItem]['max2']) {
                        $Lines[$IndexItem]['max2'] = $HighPrice;
                        $Lines[$IndexItem]['max2pos'] = $Conter;
                    }
                    if ($Lines[$IndexItem]['min1'] > $LowPrice) {
                        $Lines[$IndexItem]['min1'] = $LowPrice;
                        $Lines[$IndexItem]['min1pos'] = $Conter;
                    } elseif ($Lines[$IndexItem]['min2'] > $LowPrice) {
                        $Lines[$IndexItem]['min2'] = $LowPrice;
                        $Lines[$IndexItem]['min2pos'] = $Conter;
                    }
                } else {
                    $Lines[$IndexItem]['max1'] = $HighPrice;
                    $Lines[$IndexItem]['max1pos'] = $Conter;
                    $Lines[$IndexItem]['max2'] = $HighPrice;
                    $Lines[$IndexItem]['max2pos'] = $Conter;
                    $Lines[$IndexItem]['min1'] = $LowPrice;
                    $Lines[$IndexItem]['min1pos'] = $Conter;
                    $Lines[$IndexItem]['min2'] = $LowPrice;
                    $Lines[$IndexItem]['min2pos'] = $Conter;
                }
                $Conter++;
            } else {
                $IndexItem++;
                $Conter = 0;
            }
        }
        $result = [
            'Lines' => $Lines, // line positions
            'Percent' => $Percent, // sum of percents
            'PosPercent' => $PosPercent, // sum of positiv percents
            'NegPercent' => $NegPercent // sum of negativ percents
        ];
        return $result;
    }

    public function get_result()
    {
        $ProcessCandeles = $this->ProcessCandeles();
        $Lines = $ProcessCandeles['Lines'];
        $GMax = array();
        $GMin = array();
        $Position = 0;
        $GPercent = 0;
        foreach ($Lines  as $LineIndex => $LineItem) {
            if ($LineItem['max1pos'] == $LineItem['max2pos']) {
                $MaxG = 0;
            } elseif ($LineItem['max1pos'] > $LineItem['max2pos']) {
                $MaxG = ($LineItem['max1'] - $LineItem['max2']) / ($LineItem['max1pos'] - $LineItem['max2pos']);
            } elseif ($LineItem['max1pos'] < $LineItem['max2pos']) {
                $MaxG = ($LineItem['max2'] - $LineItem['max1']) / ($LineItem['max2pos'] - $LineItem['max1pos']);
            }
            if ($LineItem['min1pos'] == $LineItem['min2pos']) {
                $MinG = 0;
            } elseif ($LineItem['min1pos'] > $LineItem['min2pos']) {
                $MinG = ($LineItem['min1'] - $LineItem['min2']) / ($LineItem['min1pos'] - $LineItem['min2pos']);
            } elseif ($LineItem['min1pos'] < $LineItem['min2pos']) {
                $MinG = ($LineItem['min2'] - $LineItem['min1']) / ($LineItem['min2pos'] - $LineItem['min1pos']);
            }
            if ($MaxG == 0 || $MinG == 0) {
                $GMax[$LineIndex] = 0;
            } else {
                $GMax[$LineIndex] = $MaxG / $MinG;
                if ($MaxG < 0 && $MinG < 0) {
                    $GMax[$LineIndex] *= -1;
                }
            }
            if ($GMax[$LineIndex] > 0) {
                $GPercent += 10;
            }
            //$GMax[$LineIndex]=$MaxG;
            //$GMin[$LineIndex]=$MinG;
        }
        $result = [
            'GPercent' => $GPercent,
            'Percent' => $ProcessCandeles['Percent'],
            'PosPercent' => $ProcessCandeles['PosPercent'],
            'NegPercent' => $ProcessCandeles['NegPercent']

        ];
        return $result;
    }
}
