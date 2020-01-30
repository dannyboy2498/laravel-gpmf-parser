<?php

class WriteTest extends BaseTest
{
    /** @test */
    public function dummy_KLV_can_be_written_to_file()
    {
        // Arrange: create dummy klv
        $dummy_key = "TEST";
        $dummy_type = "c";
        $dummy_size = 1;
        $dummy_repeat = 1;

        $item = new KLV($dummy_key, $dummy_type, $dummy_size, $dummy_repeat);

        $bin_string = $item->encode();

        $stream = GPMFStream::fromFilename();
        $stream->loadFromString($bin_string);

    }

    public function can_write_GPS_stream_to_file()
    {

    }
}