<?php

class ParseTest extends BaseTest
{

    public function can_parse_first_container_header_in_hero7_binary_file_as_empty_nest()
    {
        // Arrange
        $fhandle = $binaries['sample_hero7.bin'];
    
        $stream = new GPMF_Stream($fhandle);
        $contents = $stream->readNext();
        $length = $contents['size']*['repeat'];

        $expected = new KLVNest("DEVC", $length);

        // Act
        
        // Assert
        $this->assertEquals();


    }

    public function ;

}