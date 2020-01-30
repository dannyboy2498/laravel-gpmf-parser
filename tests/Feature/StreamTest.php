<?php

class StreamTest extends BaseTest
{
    /** @test */
    public function gpmfstream_can_correctly_reads_first_container_header_in_hero7_binary_file()
    {
        // Arrange
        $expected_contents = array(
            'key' => 'DEVC',
            'type' => null,
            'size' => 1,
            'repeat' => 4244,
        );
        $fhandle = $binaries['sample_hero7.bin'];
        
        // Act
        $stream = new GPMF_Stream($fhandle);
        $contents = $stream->readNext();

        // Assert
        $this->assertEquals($expected_contents, $contents);
    }

    public function gpmf_stream_pointer_does_not_read_value_for_nested_klv()
    {
        // Arrange
        $fhandle = $binaries['sample_hero7.bin'];
        $stream = new GPMF_Stream($fhandle);

        $expected = stream_get_contents($stream);

        $
        rewind($stream);

        // act

        // assert check everything is working
        $this->assertEquals($expected, $stream->getPosition());
        
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

