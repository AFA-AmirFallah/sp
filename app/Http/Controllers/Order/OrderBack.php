<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\periodicUserCredit;
use App\Models\product_order;
use App\Models\product_order_items;
use App\Models\UserCredit;
use App\Models\warehouse_goods;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class OrderBack extends Controller
{

    private function back_Order_QTY($OrderID)
    {

        $Orderitem = product_order_items::where('order_id', $OrderID)->get();


        if ($Orderitem != null) {
            foreach ($Orderitem as $TargetOrderitem) {
                $ProdoctID = $TargetOrderitem->product_id;
                $QytProduct = $TargetOrderitem->product_qty;
                $Warehouse = $TargetOrderitem->pw_id;
                $ProductWarehouse = warehouse_goods::where('GoodID', $ProdoctID)->where('id',$Warehouse)->first();
                $RemianWarehouse = $ProductWarehouse->Remian;
                $QtyBack = $QytProduct + $RemianWarehouse;
                warehouse_goods::where('GoodID', $ProdoctID)->where('id',$Warehouse)->update(['Remian' => $QtyBack]);
            }
            return true;
        }
    }
    private function back_Transaction($OrderID)
    {
        $UserCredititem = UserCredit::where('InvoiceNo', $OrderID)->get();
        foreach ($UserCredititem as $usercredit) {

            $TransactionData = [
                'UserName' => $usercredit->UserName,
                'Mony' => $usercredit->Mony * -1,
                'Type' => $usercredit->Type,
                'Date' => now(),
                'Note' => 'لغو سفارش' . $OrderID,
                'TransferBy' => Auth::user()->UserName,
                'CreditMod' => $usercredit->CreditMod,
                'ConfirmBy' => Auth::user()->UserName,
                'InvoiceNo' => $OrderID,
                'GateWay' => '',
                'Confirmdate' => now(),
                'branch' => $usercredit->branch,
                'ReferenceId' => $usercredit->ReferenceId,

            ];
            usercredit::create($TransactionData);
        }
        return true;
    }
    private function back_periodical($OrderID)
    {
        $UserPeriodicitem = periodicUserCredit::where('InvoiceNo', $OrderID)->get();
        if ($UserPeriodicitem == null) {
            return false;
        } else {
            foreach ($UserPeriodicitem as $UserPeriodic) {
                $CreditData = [
                    'UserName' => $UserPeriodic->UserName,
                    'Mony' => $UserPeriodic->Mony * -1,
                    'Type' => $UserPeriodic->Type,
                    'Date' => now(),
                    'Note' => 'لغو سفارش' . $OrderID,
                    'TransferBy' => Auth::user()->UserName,
                    'CreditMod' => $UserPeriodic->CreditMod,
                    'ConfirmBy' => Auth::user()->UserName,
                    'InvoiceNo' => $OrderID,
                    'GateWay' => '',
                    'Confirmdate' => now(),
                    'branch' => $UserPeriodic->branch,
                    'ReferenceId' => $UserPeriodic->ReferenceId,
                ];
                periodicUserCredit::create($CreditData);
            }
            return true;
        }
    }
    private function ChangeStatusOrder($OrderID)
    {
        product_order::where('id', $OrderID)->update(['status' => 60]);
    }

    public function Cancel_Order($OrderAtribute)
    {
        $OrderID = $OrderAtribute['OrderID'];
        $UserName = $OrderAtribute['UserName'];

        $this->back_Order_QTY($OrderID);
        $this->back_Transaction($OrderID);
        $this->back_periodical($OrderID);
        $this->ChangeStatusOrder($OrderID);
        return true;
    }
}
