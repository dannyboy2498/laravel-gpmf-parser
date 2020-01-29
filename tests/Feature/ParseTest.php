<?php

class ParseTest extends BaseTest
{
    public function can_create_singular_KLV_from_GPMFStream()
    {
        $fhandle = $binaries['sample_binary.bin'];
    
        $stream = new GPMF_Stream($fhandle);
    
        $key = "Test";
        $type = 'b';
        $size = 1;
        $repeat = 1;
        
        $expected = new KLVBase($key, $type, $size, $repeat);
            
        $kvl = $stream->readNext();
    
    }

    public function can_create_create_nested_KVL_from_GPMFStream()
    {

    }
}