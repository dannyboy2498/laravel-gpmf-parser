<?php

namespace Dan\GPMF;

use Dan\GPMF\KLVBase;

class GPMFParser 
{
    //protected ;
    
    private function __construct()
    {
        // $this->stream = $stream;
    }

    public function getClassFromKey()
    {
        switch ($type)
        {
            case 'DEVC': return;
            case 'STRM': return;
        }
    }

    public function covertToPHPType($type)
    {
        switch ($type)
        {
            case 'b': // single byte signed int8_t
            case 'B': // single byte unsigned uint_t
            case 'c': // single byte char
            case 'd': // 8 byte double
            case 'f': // 4 byte float
            case 'F': // 4 byte char key "FourCC"
            case 'G': // 16 byte ID (like UUID)
            case 'j': // 8 byte signed int64_t
            case 'J': // 8 byte unsigned uint64_t
            case 'l': // 8 byte 
            case 'L': //
            case 'q': //
            case 'Q': //
            case 's': //
            case 'S': //
            case 'U': // char[16] UTC time format
            case '?': // complex read preceeding?
            case null: // nested metadata
        }
    }

    public function decodeGPMFStream($stream) // iteratively
    {
        $tree = new KLVNest("FILE", $stream->getLength());
        $stack = array();
        $stack_length = array();
        $offset_last = $stream->offset();
        $current_nest = $tree;
        while (!feof($stream))
        {
            $contents = $stream->readNext();
            $item = KLVBase::decodeFromGPMFStream($contents);
            
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
    }
}