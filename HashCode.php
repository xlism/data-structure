<?php
/**
 * hash code
 * User: sammyle
 * Date: 2020-03-24
 * Time: 11:17
 */

/**
 * @param $str
 * @return int
 */
function hashCode64($str)
{
    $str = (string)$str;
    $hash = 0;
    $len = strlen($str);
    if ($len == 0) {
        return $hash;
    }

    for ($i = 0; $i < $len; $i++) {
        $h = $hash << 5;
        $h -= $hash;
        $h += ord($str[$i]);
        $hash = $h;
        $hash &= 0xFFFFFFFF;
    }

    return $hash;
}


function hashCode32($s)
{
    $h = 0;
    $len = strlen($s);
    for ($i = 0; $i < $len; $i++) {
        $h = overflow32(31 * $h + ord($s[$i]));
    }

    return $h;
}

function overflow32($v)
{
    $v = $v % 4294967296;
    if ($v > 2147483647) {
        return $v - 4294967296;
    } elseif ($v < -2147483648) {
        return $v + 4294967296;
    } else {
        return $v;
    }
}