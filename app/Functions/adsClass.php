<?php


namespace App\Functions;

use App\Models\posts;
use App\myappenv;
use Session;


class adsClass
{
    /**
     * Undocumented function
     *
     * @param array $TargetProperty
     * $TargetProperty [
     *  Str TargetPage,
     *  Str TargetUser,
     *  int Limit
     * ]
     * 
     * @return void
     */
    public function get_ads(array $TargetProperty)
    {
        $AdsSource = posts::where('adds', '>', 0)->where('status', 1)->get();
        $AdsSource = $this->shownewsProcedures($AdsSource, $TargetProperty);
        return $AdsSource;
    }
    private function DeactiveAds($AdID)
    {
        posts::where('ID', $AdID)->update(['status' => 0]);
        return true;
    }
    private function AdFinancial($AdAttr)
    {
        posts::where('id', $AdAttr['AdID'])->increment('CreatorPrice', $AdAttr['Price']);
        return true;
    }
    /**
     * this function use to move CreatorPrice to usercredit table 
     * Normaly this function should run end of date and replace all credit 
     * usercredit table but when $PostId is set this function move credit from one post only
     *
     * @param [type] $PostId
     * @return void
     */
    private function FinalizeFinancial($PostId = null)
    {
        $Financial = new FinancialTransfer();
        if ($PostId == null) {
            $HasCreditRows = posts::whereNotNull('CreatorPrice')->get();
            foreach ($HasCreditRows as $HasCreditRowItem) {
                $Note = 'کسر بابت تبلیغات داخل سایت';
                $Note .= 'آگهی شماره : ' . $HasCreditRowItem->id;
                $CreditAttr = [
                    'UserName' => $HasCreditRowItem->Writer,
                    'Mony' => -1 * $HasCreditRowItem->CreatorPrice,
                    'Type' => 27,
                    'CreditMod' => myappenv::CachCredit,
                    'branch' => myappenv::Branch,
                    'SanadName' => $Note,
                    'TransferBy' => 'system',
                    'ConfirmBy' => 'system'
                ];
                $Financial->AddCredit($CreditAttr);
                posts::where('id', $HasCreditRowItem->id)->update(['CreatorPrice' => null]);
            }
        } else {
            $HasCreditRowItem = posts::where('id', $PostId)->first();
            $Note = 'کسر بابت تبلیغات داخل سایت';
            $Note .= 'آگهی شماره : ' . $PostId;
            $CreditAttr = [
                'UserName' => $HasCreditRowItem->Writer,
                'Mony' => -1 * $HasCreditRowItem->CreatorPrice,
                'Type' => 27,
                'CreditMod' => myappenv::CachCredit,
                'branch' => myappenv::Branch,
                'SanadName' => $Note,
                'TransferBy' => 'system',
                'ConfirmBy' => 'system'
            ];
            $Financial->AddCredit($CreditAttr);
            posts::where('id', $PostId)->update(['CreatorPrice' => null]);
        }
    }

    private function befreshowProcedures($AdsSource, $TargetProperty)
    {
        $Output = array();
        foreach ($AdsSource as $AdsSourceItem) {
            if ($AdsSourceItem->Price != null) {
                $Price = $AdsSourceItem->Price;
                $Owner = $AdsSourceItem->Writer;
                $Myfinancial = new Financial();
                $UserCredit = $Myfinancial->UserHasCredite($Owner, myappenv::CachCredit);
                if ($AdsSourceItem->CreatorPrice == null) {
                    $OldPrice = 0;
                    posts::where('id', $AdsSourceItem->id)->update(['CreatorPrice' => 0]);
                } else {
                    $OldPrice = $AdsSourceItem->CreatorPrice;
                }

                if ($UserCredit >= $Price + $OldPrice) {
                    $AdAttr = [
                        'Owner' => $Owner,
                        'Price' => $Price,
                        'AdID' => $AdsSourceItem->id
                    ];
                    $this->AdFinancial($AdAttr);
                } else {
                    $this->DeactiveAds($AdsSourceItem->ID);
                    $this->FinalizeFinancial($AdsSourceItem->ID);
                }
            }
            array_push($Output, $AdsSourceItem);
        }
        return $Output;
    }
    private function SaveAdlog($AdsSource)
    {
        //TODO: updae fielid if
        dd($AdsSource);
        $SessionID = Session::getId(); 
        dd($SessionID);
    }
    private function shownewsProcedures($AdsSource, $TargetProperty)
    {
        dd($TargetProperty);
        $AdsSource = $this->befreshowProcedures($AdsSource, $TargetProperty);
        $this->SaveAdlog($AdsSource);
        return $AdsSource;

    }
}
