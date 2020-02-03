<?php

namespace Dan\GPMF\KLV\Types;

class GPSU extends KLVBase
{
    protected $value; // date-time
    
    public function decodeValueFromBinaryString($string)
    {
        $date = '20' . unpack('a16', $string)[1];
        $this->value = date_create_from_format('YmdGis.u', $date);
    }
}