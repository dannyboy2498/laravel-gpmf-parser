<?php

namespace Dan\GPMF;

class GPMFStream
{
    protected $handle;
    protected $offset_last;
    //protected $nest_stack;

    public function __construct($handle = null)
    {
        $this->handle = $handle;
        $this->offset_last = $this->offset();
        //$this->nest_stack = array();
        //if (!isset($handle))
        //{
        //    fopen('php://temp', 'wb+');
        //}
        return $this;
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
        //
    }
    
    /* Navigate through GMPF Stream **/

    public function offset() { return ftell($this->handle); }
    public function rewind() { rewind($this->handle); }
    public function EOS() { return feof($this->handle); }

    public function getStackLevel() { return count($this->nest_stack); }

    public function revert()
    {
        $this->seek($this->offset_last, SEEK_SET, false);
    }

    public function seek($pos, $flag = SEEK_SET, $record = true)
    {
        if ($record)
            $this->offset_last = $this->offset;
        fseek($this->handle, $pos, $flag);
    }

    public function getNextKey()
    {
        $key = $this->decodeBinary('a4', 4);
        $this->seek(-4, SEEK_CUR, false);
        return $key;
    }

    public function getNextType()
    {
        $this->seek(4, SEEK_CUR, false);
        $type = $this->decodeBinary('a1', 1);
        if ($type == '\\0')
            $type = null;
        $this->seek(-5, SEEK_CUR, false);
        return $type;
    }

    public function getNextLength()
    {
        $this->seek(5, SEEK_CUR, false);
        $size = $this->decodeBinary('C1', 1);
        $repeat = $this->decodeBinary('n1', 2);
        $this->seek(-8, SEEK_CUR, false);
        return $size*$repeat;
    }

    public function readNext()
    {
        if ($this->offset % 4 != 0) // not 32bit aligned
            return null;

        $this->offset_last = $this->offset();

        $header_contents = decodeHeader();
        if ($header_contents == null) return null;
        $value_binary = null;
        if ($header_contents['type'] != null)
            $value_binary = readValue($header_contents['size']*$header_contents['repeat']);
        return array($header_contents['key'], $header_contents['type'], $header_contents['size'], $header_contents['repeat'], $value_binary);
    }

    public function findNext($key)
    {
        $this->offset_last = $this->offset();
        $pos = -1;
        while (!$this->EOS())
        {
            if ($key == $this->getNextKey())
            {
                $pos = $this->offset();
                break;
            }
            skipNext(false);
        }
        $this->revert();
        return $pos;
    }

    public function skipNext($record = true)
    {
        $type = $this->getNextType();

        if ($type === null)
            $this->seek(8, SEEK_CUR, $record);
            // add to stack
        else
            $length = $this->getNextLength();
            $this->seek(8+$length, SEEK_CUR, $record);
    }

    public function skipNest()
    {
        //
    }

    private function readValue($length)
    {
        $padding = $length % 4; // 32 bit align the stream
        $bin_string = fread($this->stream, $length+$padding);
        return $bin_string;
    }

    /* Parsing functions */

    public function decode() // iteratively
    {
        $stream = $this;
        $stream->rewind();
        $tree = new KLVNest("FILE", $stream->getLength());
        $stack = array();
        $stack_length = array();
        $offset_last = $stream->offset();
        $current_nest = $tree;

        while (!feof($stream->$handle))
        {
            $item = KLVBase::createFromGPMFStream($stream);
            
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

    private function decodeHeader()
    {
        $bin_string = fread($this->handle, 8);
        if (strlen($bin_string) != 8) return null;
        $header_format = 'a4key/a1type/C1size/n1repeat';
        $contents = unpack($header_format, $bin_string);
        if ($contents['type'] == '\\0')
            $contents['type'] = null;
        return $contents;
    }

    private function decodeBinary($format, $length = 1)
    {
        $bin_string = fread($this->handle, $length);
        return pack($format, $bin_string)[0];
    }
}
