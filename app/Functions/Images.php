<?php


namespace App\Functions;

use Hamcrest\Arrays\IsArray;

class Images
{
    public function AddNewImageJson($OldimagesJson, $Newpicrefrence, $NewImageURL)
    {

        $picrefrence = explode(",", $Newpicrefrence);

        $picrefrenceID = $picrefrence[0];
        $PicrefrenceName = $picrefrence[1];
        $newObj = array("picrefrence" => $picrefrenceID, "PicrefrenceName" => $PicrefrenceName, "ImageURL" => $NewImageURL);
        $myObj = array();
        if ($OldimagesJson == null) {
            array_push($myObj, $newObj);
        } else {
            $OldArray = json_decode($OldimagesJson, true);

            $i = 0;
            $OldArrayTmp = array();
            foreach ($OldArray as $imageItem) {
                if ($imageItem['picrefrence'] != $picrefrenceID) {
                    //unset($OldArray[$i]);
                    array_push($OldArrayTmp, $imageItem);
                }
                $i++;
            }
            $OldArray = $OldArrayTmp;
            array_push($OldArray, $newObj);
            $myObj = $OldArray;
        }
        $ImgURL = json_encode($myObj, JSON_UNESCAPED_UNICODE);
        return $ImgURL;
    }

    public function GetPicturesArray($JsonArray)
    {
        return json_decode($JsonArray, true);
    }
    public static function GetPicture($JsonArray, $imagetarget)
    {
        $SelectedImage = null;
        if ($JsonArray != null) {
            $OldArray = json_decode($JsonArray, true);
            if(is_array($OldArray)){
                foreach ($OldArray as $imageItem) {
                    if ($imageItem['RefrenceID'] == $imagetarget) {
                        $SelectedImage = $imageItem['PicUrl'];
                    }
                }
            }else{
                $SelectedImage = null;
            }

        } else {
            $SelectedImage = null;
        }

        return $SelectedImage;
    }

    public function GetMainPictureAddress($JsonArray, $imagetarget = null)
    {
        $SelectedImage = null;
        //todo: select image based on the policy
        if ($JsonArray != null) {
            $OldArray = json_decode($JsonArray, true);
            if ($imagetarget == null) {
                foreach ($OldArray as $imageItem) {
                    $SelectedImage = $imageItem['ImageURL'];
                }
            } else {
                foreach ($OldArray as $imageItem) {
                    if ($imageItem['picrefrence'] == $imagetarget) {
                        $SelectedImage = $imageItem['ImageURL'];
                    }
                }
            }
        } else {
            $SelectedImage = null;
        }

        return $SelectedImage;
    }
}
