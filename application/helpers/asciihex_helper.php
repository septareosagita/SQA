<?php

/**
 * @author irfan.satriadarma
 * @copyright 2009
 */
// convert an ascii string to its hex representation
function AsciiToHex($ascii) {
    $hex = '';

    for ($i = 0; $i < strlen($ascii); $i++)
        $hex .= str_pad(base_convert(ord($ascii[$i]), 10, 16), 2, '0', STR_PAD_LEFT);

    return $hex;
}

// convert a hex string to ascii, prepend with '0' if input is not an even number
// of characters in length
function HexToAscii($hex) {
    $ascii = '';

    if (strlen($hex) % 2 == 1)
        $hex = '0' . $hex;

    for ($i = 0; $i < strlen($hex); $i += 2)
        $ascii .= chr(base_convert(substr($hex, $i, 2), 16, 10));

    return $ascii;
}

function mixing_an_array($arr_list) {
    $arr_ret = array();
    if ($arr_list) {
        foreach ($arr_list as $i) {
            $arr_ret[] = $i;
        }
    }
    return $arr_ret;
}

function is_readwrite($arr_menus, $uri_segment) {
    $readwrite = true;
    foreach ($arr_menus as $m):
        if ($uri_segment == $m[1])
            if ($m[0] == '1') $readwrite = false;        
    endforeach;
    return $readwrite;
}

function normal_number($number) {
    return str_replace('.', '', $number);
}

function debug_array($arr, $die = false) {
    echo '<pre>'; print_r($arr); echo '</pre>';
    if ($die) {
        die();
    }
}

function get_bulan($b) {
    $bln = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    return $bln[$b];
}

function bulans() {
    return array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
}

function clear_menux($menux) {
    $mn = array();
    foreach ($menux as $m) {        
        $mx = explode('/', $m);
        $mn[] = (count($mx) == 2) ? $mx[0] : $m;
    }    
    return $mn;
}

?>