<?php
namespace App\Http\Controllers\WPA;
use App\Http\Controllers\Controller;
use App\Models\L3Work;
use App\myappenv;
use Illuminate\Http\Request;

class classification extends Controller
{
    public function wpaclassification(){

        $Cats =  L3Work::all()->where('WorkCat',myappenv::CatsToOffer_workcat)->where('L1ID',myappenv::CatsToOffer_L1)->where('L2ID',myappenv::CatsToOffer_L2);
        return view("WPA.Classification.wpaclassification",['Cats'=>$Cats]);
    }
}
