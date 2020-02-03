<?php

namespace Dan\GPMF\KLV\Types;

class KLVSingular extends KLVBase // single payload
{
    protected $value;
    protected $format;

    public function decodeValueFromBinaryString($string)
    {
        setFormatFromType($this->$type);
        for ($i=0;$i<$this->repeat;$i++)
        {
            $contents = unpack($this->format, $string);

            // if type unsigned
            // array_map('convert_unsigned32_to_signed', $contents);
        }
    }

    function setFormatFromType()
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
            case 'l': // 4 byte signed int32_t
            case 'L': // 4 byte unsigned uint32_t
            case 'q': // 4 byte q number
            case 'Q': // 8 byte q number
            case 's': // 2 byte signed int16_t
            case 'S': // 2 byte unsigned uint16_t
            case 'U': // char[16] UTC time format
            case '?': // complex structure is defined with preciding TYPE KLV
            case null: // nested metadata
            default:
                return null;
        }
    }
}