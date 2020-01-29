<?php

namespace Dan\GPMF;

class GPMFStream
{
    protected $handle;
    protected $lastSeek;

    private function __construct($handle = null)
    {
        $this->handle = $handle;
        if (!isset($handle))
        {
            fopen('php://temp', 'wb+');
        }
    }

    private function __destruct()
    {
        fclose($this->handle);
    }

    /* Arrange Stream **/
    public function loadFromStream($stream)
    {
        fwrite($this->handle, stream_get_contents($stream));
        rewind($this->handle);
    }

    public function loadFromString($string)
    {
        fwrite($this->handle, $string);
        rewind($this->handle);
    }

    public function validate()
    {
        
    }
    
    /* Navigate through GMPF Stream **/

    public function readNext()
    {
        // if nested only read header
        $header_contents = readHeader();
        if ($header_contents == null) return null;
        $value_binary = readValue();
        return array($header_contents['key'], $header_contents['type'], $header_contents['size'], $header_contents['repeat'], $value_binary);
    }

    public function getSamples()
    {

    }

    public function scale()
    {

    }

    private function readHeader()
    {
        $bin_string = fread($this->stream, 8);
        if (strlen($bin_string) != 8) return null;
        $header_format = 'a4key/a1type/C1size/n1repeat';
        $contents = unpack($header_format, $bin_string);
        return $contents;
    }

    public function readValue($type, $size, $repeat, ?int $scale = 1)
    {

    }

    public function findNextKey($key)
    {
        
    }

    /* current KVL property functions **/
    public function readKey()
    {
        
    }
}
