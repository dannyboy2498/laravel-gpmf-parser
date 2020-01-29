<?php

namespace Dan\GPMF\KLV\Types;

use Dan\GPMF\KLV\KLVBase;

class KLVBinary extends KLVBase
{
    protected $value;

    public function decodePayload($binary_string)
    {
        $this->value = $binary_string;
    }

}