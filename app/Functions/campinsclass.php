<?php


namespace App\Functions;

use App\Models\campain_meta;
use App\myappenv;
use Auth;

class campinsclass
{
    public function  create_campin_meta($name, $desc, $buget, $expriredate, $startdate, $creator)
    {
        $CampinData = [
            'name' => $name,
            'desc' => $desc,
            'staus' => 0,
            'buget' => $buget,
            'usedprice' => 0,
            'startdate' => $startdate,
            'expriredate' => $expriredate,
            'creator' => $creator,
        ];
        $result = campain_meta::create($CampinData);
        return $result->id;
    }
    public function get_campin_meta_all()
    {
        $UserRole = Auth::user()->Role;
        if ($UserRole >= myappenv::role_Accounting) {
            return campain_meta::all();
        } else {
            return campain_meta::where('staus' > 50)->get();
        }
    }    
    public function get_campin_meta($id)
    {
        $UserRole = Auth::user()->Role;
        if ($UserRole >= myappenv::role_Accounting) {
            return campain_meta::where('id',$id)->first();
        } else {
            return campain_meta::where('staus' > 50)->where('id',$id)->first();
        }
    }
    public function get_status_meta($Status)
    {
        switch ($Status) {
            case 0:
                return 'در انتظار تایید ادمین';
                break;
            case 100:
                return 'فعال';
                break;
            default:
                return 'خطا';
        }
    }

    public function create_campin()
    {
    }

    public function create_campin_reseve()
    {
    }

    public function create_campin_used()
    {
    }
    public function update_campin()
    {
    }

    public function update_campin_meta()
    {
    }

    public function update_campin_reseve()
    {
    }
    public function delete_campin()
    {
    }

    public function delete_campin_meta()
    {
    }

    public function delete_campin_reseve()
    {
    }

    public function get_user_reserved_campain()
    {
    }
}
