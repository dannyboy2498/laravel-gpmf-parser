<?php

namespace Dan\GPMF\KLV\Types;

class STRM extends KLVNest // Hopefully replace this with GPS and Acceleration tags
{
    //protected $type;

    function average($key, $property)
    {
        $children = $this->children;
        array_filter($children, function ($child) use ($key) { return $child->key == $key; });
        $sum = 0;
        // average values across filtered child
        // array_map(function ($child) use (&$sum) { $sum += $child->}; )
    }
}