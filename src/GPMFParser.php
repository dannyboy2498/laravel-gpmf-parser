<?php

namespace Dan\GPMF;

use Dan\GPMF\KLVBase;
use Dan\GPMF\GPMFStream;

class GPMFParser // empty class to potentially migrate decode/encoding here from GPMFStream
{
    protected $stream;

    private function __construct(GPMFStream $stream)
    {
        $this->stream = $stream;
    }

    public function treeToGPMFStream()
    {
        //
    }

    public function exportTreeAsCollection()
    {
        // 
    }
}