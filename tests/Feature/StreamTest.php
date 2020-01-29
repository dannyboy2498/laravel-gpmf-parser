<?php

class StreamTest extends BaseTest
{
    /** @test */
    public function gpmfstream_can_determine_valid_singular_KLV()
    {
        // arrange
        $fhandle = $binaries['sample_singular.bin'];
    
        $stream = new GPMF_Stream($fhandle);

        $expected = stream_get_contents($stream);
        rewind($stream);

        // act
        $stream->validate();

        // assert check everything is working
        $this->assertEquals($expected, stream_get_contents($stream));
        
    }
    public function gpmfstream_can_determine_valid_nested_KLV_from_binary_file()
    {
        // arrange
        $fhandle = $binaries['sample_nested.bin'];

        $stream = new GPMF_Stream($fhandle);

        $expected = stream_get_contents($stream);
        rewind($stream);

        // act
        $stream->validate();

        // assert check everything is working
        $this->assertEquals($expected, stream_get_contents($stream));
    }

    /* @test **/
    public function stream_can_insert_singular_KVL_into_file()
    {
        // arrange
        $fihandle = $binaries['sample_singular.bin'];
        $fohandle = $binaries['sample_empty.bin'];

        $rstream = new GPMF_Stream($fihandle);
        $expected = stream_get_contents($rstream);
        rewind($rstream);

        // act
        $rstream = new GPMF_Stream($fihandle);

        $wstream = new GPMF_Stream($fohandle);

        $wstream->loadFromStream($rstream);

        // assert
        rewind($fohandle);
        $this->assetEquals($expected, stream_get_contents($fohandle));
    }

    /* @test **/
    public function stream_can_insert_nested_KVL_into_file()
    {
        // arrange
        $fihandle = $binaries['sample_nested.bin'];
        $fohandle = $binaries['sample_empty.bin'];

        $rstream = new GPMF_Stream($fihandle);
        $expected = stream_get_contents($rstream);
        rewind($rstream);

        // act
        $rstream = new GPMF_Stream($fihandle);

        $wstream = new GPMF_Stream($fohandle);

        $wstream->loadFromStream($rstream);

        // assert
        rewind($fohandle);
        $this->assetEquals($expected, stream_get_contents($fohandle));
    }
}

