<?php

namespace Dan\GPMF\KLV\Types;

use Dan\GPMF\KLV\KLVBase;
use Dan\GPMF\Common;

class ACCL extends KLVBase
{
    protected $ax;
    protected $ay;
    protected $az;

    protected bool $isScaled;

    public function decodeFromBinaryString($string)
    {
        for ($i=0;$i<$this->repeat;$i++)
        {
            $format = 'Nay/Nax_neg/Naz';
            $contents = unpack($format, $string);
            array_map('convert_unsigned32_to_signed', $contents);

            $this->setAcceleration(-$contents['ax_neg'], $contents['ay'], $contents['az']);
            
            $this->scale();
        }
    }

    function setAcceleration($ax, $ay, $az) { 
        [$this->ax, $this->ay, $this->az] = array($ax, $ay, $az); 
    }

    function scale()
    {
        array_map(function ($val) { return $val /= 418; }, $this->acceleration);
    }

    function reverseScale()
    {
        array_map(function ($val) { return $val *= 418; }, $this->acceleration);
    }
}