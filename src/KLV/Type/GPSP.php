<?php

namespace Dan\GPMF\KLV\Types;

class GPSP extends KLVBase
{
    protected $value; // dilution of precision
    
    public function decodeFromBinaryString($string)
    {
        $this->value = unpack('n', $string)[0];
    }
}