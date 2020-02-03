<?php

namespace Dan\GPMF\KLV\Types;

class GPSP extends KLVBase
{
    protected $value; // dilution of precision
    
    public function decodeValueFromBinaryString($string)
    {
        $this->value = unpack('n', $string)[0];
    }

    public function encode($stream)
    {
        $stream = fuc;
    }
}