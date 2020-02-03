<?php

namespace Dan\GPMF\KLV\Types;

use Dan\GPMF\KLV\KLVBase;

class KLVBinary extends KLVBase // unparsed
{
    protected $value;

    public function decodeValueFromBinaryString($binary_string)
    {
        $this->value = $binary_string;
    }

    
}