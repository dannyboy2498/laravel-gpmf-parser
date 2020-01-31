<?php

namespace Dan\GPMF\Tests;

use phpDocumentor\Reflection\Types\Void_;
use Dan\GPMF\Tests\BaseTest;
use Tightenco\Collect\Support\Collection;

class StreamTest extends BaseTest
{
    /** @test */    
    public function gpmf_stream_only_reads_header_when_reading_next_klv_for_nested_klv()
    {
        // Arrange
        $fhandle = $binaries['hero7_sample.bin'];
        $stream = new GPMF_Stream($fhandle);
        $stream->readHeader();
        $expected = $stream->offset();
        $stream->rewind();

        // Act
        $stream->readNext();

        // Assert 
        $this->assertEquals($expected, $stream->offset());
        
    }

    /** @test */
    public function gpmfstream_can_correctly_parse_first_container_header_in_hero7_binary_file()
    {
        // Arrange
        $expected_contents = array(
            'key' => 'DEVC',
            'type' => null,
            'size' => 1,
            'repeat' => 4244,
        );
        $fhandle = $binaries['hero7_sample.bin'];
        
        // Act
        $stream = new GPMF_Stream($fhandle);
        $contents = $stream->readNext();

        // Assert
        $this->assertEquals($expected_contents, $contents);
    }

    public function gpmf_stream_seeks_in_32bit_alignment()
    {
        // Arrange
        $fhandle = $binaries['hero7_sample.bin'];
        $stream = new GPMF_Stream($fhandle);
        $expected = array();

        // Act & Assert
        while (!$stream->EOS())
        {
            $stream->skipNext();
            $this->assertEquals(0,$stream->offset() % 4);
        }
        
    }

    public function gpmf_stream_reads_in_32bit_alignment()
    {
        // Arrange
        $fhandle = $binaries['hero7_sample.bin'];
        $stream = new GPMF_Stream($fhandle);
        $expected = array();

        // Act & Assert
        while (!$stream->EOS())
        {
            $stream->readNext();
            $this->assertEquals(0,$stream->offset() % 4);
        }
        
    }

    /*
    public function gpmf_stream_increments_nest_depth_level_when_seeking_past_klv_nest_header()
    {
        // Arrange
        $fhandle = $binaries['hero7_sample.bin'];
        $stream = new GPMF_Stream($fhandle);
        $level_last = 0;
        $found_nest = false;
        while (!$stream->EOS() || !$found_nest)
        {
            if ($stream->getNextType() === null) { $found_nest = true; }
        }

        // Act
        $stream->skipNext();

        // Assert
        $this->assertEquals(1,$stream->current_nest_level);
    }

    public function gpmf_stream_decrements_nest_depth_level_when_seeking_past_klv_nest_value_end()
    {
        // Arrange
        $fhandle = $binaries['hero7_sample.bin'];
        $stream = new GPMF_Stream($fhandle);
        $found_nest = false;
        while (!$stream->EOS() || !$found_nest)
        {
            if ($stream->getNextType() === null) { $found_nest = true; }
        }
        $level_last = 1;

        // Act
        $stream->skipNest();

        // Assert
        $this->assertEquals(0,$stream->current_nest_level);
    }
    */
}