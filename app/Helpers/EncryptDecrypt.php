<?php

use Hashids\Hashids;

function id2hash($id){
    $hashids = new Hashids('unipay123!@#', 8);
    return $hashids->encode($id);
}

function hash2id($hash){
    $hashids = new Hashids('unipay123!@#', 8);
    return $hashids->decode($hash)[0];
}
