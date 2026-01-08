<?php


namespace App\Functions;


class TokenClass
{

    function UniqueToken($len= 8) {
        return substr(md5(uniqid(mt_rand(), true)), 0, $len);
    }
}
