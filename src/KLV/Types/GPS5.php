<?php

namespace Dan\GPMF\KLV\Types;

use Dan\GPMF\KLV\KLVBase;

class GPS5 extends KLVBase
{
    protected $long;
    protected $lat;
    protected $altitude;
    protected $speed2;
    protected $speed3;

    public function decodePayload()
    {
        
    }
}