<?php


namespace App\Functions;


class JsonWorks
{
    public function GetJsonInArray($JsonArray)
    {
        return json_decode($JsonArray, true);
    }

    public function jsonencode($myObj)
    {
        return json_encode($myObj, JSON_UNESCAPED_UNICODE);
    }
    public function JsonUpdate($OldJosn, $Newfield, $NewValue){
        if($OldJosn == null){
                $JsonFild[$Newfield]=$NewValue;
                $JsonFild = json_encode($JsonFild);
        }else{
            $JsonFild = $this->GetJsonInArray($OldJosn);
            if(isset($JsonFild[$Newfield])){
                $JsonFild[$Newfield]=$NewValue;
                $JsonFild = json_encode($JsonFild);
            }else{
                $JsonFild = $this->AddToOldJson($OldJosn, $Newfield, $NewValue);
            }

        }
        return $JsonFild;
    }
    public function AddToOldJson($OldJosn, $Newfield, $NewValue)
    {
        $OldJosn = json_decode($OldJosn);
        array_push($OldJosn, array($Newfield, $NewValue));
        $Result = json_encode($OldJosn);
        return $Result;

    }


}
