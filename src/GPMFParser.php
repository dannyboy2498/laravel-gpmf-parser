<?php

namespace Dan\GPMF;

use Dan\GPMF\KLVBase;
use Dan\GPMF\GPMFStream;

class GPMFParser 
{
    protected $stream;
    protected $tree;

    private function __construct(GPMFStream $stream)
    {
        $this->stream = $stream;
        $this->tree = null;
    }

    public function treeFromGPMFStream(GPMFStream $stream) // iteratively
    {
        $tree = new KLVNest("FILE", $stream->getLength());
        $stack = array();
        $stack_length = array();
        $offset_last = $stream->offset();
        $current_nest = $tree;

        while (!feof($stream))
        {
            $item = KLVBase::decodeFromGPMFStream($stream);
            
            if (get_class($current_nest) == 'KLVNest')
                $current_nest->addChild($item);

            if (get_class($item) == 'KLVNest')
            {
                array_push($stack, $current_nest);
                array_push($stack_length, $current_nest->getLength()+$offset_last);
                $current_nest = $item;
            }

            if ($stack_length[array_key_last($stack_length)] < $stream->offset())
            {
                $current_nest = array_pop($stack);
                array_pop($stack_length);
            }
            $offset_last = $stream->offset();
        }

        return $tree;
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