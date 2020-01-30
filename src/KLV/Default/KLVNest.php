<?php

namespace Dan\GPMF\KLV\Types;

use Dan\GPMF\KLV\KLVBase;

class KLVNest extends KLVBase
{
    protected $children = array();

    private function __construct($key, $length)
    {
        parent::__construct($key, null, 1, $length);
    }

    public function addChild(KLVBase $child)
    {
        $children = array_push($child);
    }

    function encode()
    {
        //
    }
}