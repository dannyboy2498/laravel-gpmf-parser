<?php
namespace Dan\GMPF;

class KLVBase
{
    protected $key;
    protected $type;
    protected $size;
    protected $repeat;

    protected $parent;

    public function __construct($key, $type, $size, $repeat)
    {
        [$this->key, $this->type, $this->size, $this->repeat] = array($key, $type, $size, $repeat);
    }

    public function __get($propertyName) // make all protected values readonly publicly
    {
        if (property_exists(get_class($this), $propertyName))
        {
            return $this[$propertyName];
        }
    }

    public function length()
    {
        return $this->size * $this->repeat;
    }

    public static function getRecognisedTypes()
    {
        $types = array(
            "DEVC",
            "STRM",
            "GPS5",
            "GPSU",
            "GPSP",
            "ACCL"
        );
    }

    private static function getClassFromKey($key)
    {
        switch ($key)
        {
            case "DEVC":
            case "STRM":
                return KLVNest::class;
                break;
            case "GPS5":
                return GPS5::class;
            case "GPSU":
                return GPSU::class;
            case "GPSF":
                return GPSF::class;
            case "GPSP":
                return GPSP::class;
            case "ACCL":
                return ACCL::class;
                break;
            default:
                return KLVBinary::class;
                break;
        }
    }

    public static function createFromGPMFStream($stream)
    {
        [$key, $type, $size, $repeat, $value_binary] = $stream->readNext();
        $class = getClassFromKey($key);

        $item = new $class($key, $type, $size, $repeat);

        $item->decodeValueFromBinaryString($value_binary);

        return $item;
    }

    
}