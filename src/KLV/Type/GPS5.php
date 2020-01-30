<?php

namespace Dan\GPMF\KLV\Types;

use Dan\GPMF\KLV\KLVBase;
use Dan\GPMF\Common;

class GPS5 extends KLVBase
{
    protected $lat;
    protected $long;
    protected $altitude;
    protected $speed2;
    protected $speed3;

    protected bool $isScaled;

    public function decodeFromBinaryString($string)
    {
        for ($i=0;$i<$this->repeat;$i++)
        {
            $format = 'Nlat/Nlong/Naltitude/Nspeed2/Nspeed3';
            $contents = unpack($format, $string);
            array_map('convert_unsigned32_to_signed', $contents);

            $this->setLatitude($contents['lat'])
                 ->setLongitude($contents['long'])
                 ->setAltitude($contents['altitude'])
                 ->setSpeed2D($contents['speed2'])
                 ->setSpeed3D($contents['speed3']);
            
            $this->scale();
        }
    }

    function setLatitude($lat) { $this->lat = $lat; }
    function setLongitude($long) { $this->long = $long; }
    function setAltitude($altitude) { $this->altitude = $altitude; }
    function setSpeed3D($speed2) { $this->speed2 = $speed2; }
    function setSpeed2D($speed2) { $this->speed2 = $speed2; }


    function scale()
    {
        $this->lat /= 10000000;
        $this->long /= 10000000;
        $this->altitude /= 1000;
        $this->speed2 /= 1000;
        $this->speed3 /= 100;
        $this->isScaled = true;
    }

    function reverseScale()
    {
        $this->lat *= 10000000;
        $this->long *= 10000000;
        $this->altitude *= 1000;
        $this->speed2 *= 1000;
        $this->speed3 *= 100;
        $this->isScaled = false;
    }
}