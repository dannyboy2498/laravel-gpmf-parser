<?php

namespace Dan\GPMF\Tests;

use phpDocumentor\Reflection\Types\Void_;
use Dan\GPMF\Tests\BaseTest;
use Tightenco\Collect\Support\Collection;

class ParseTest extends BaseTest
{
    /** @test */
    public function can_decode_recognised_klv_types()
    {
        $recognised_types = KLVBase::getRecognisedTypes();
        array_map(array($this, 'can_decode_recognised_klv_type'), $recognised_types);
    }

    public function can_decode_recognised_klv_type($type)
    {
        // Arrange
        $fhandle = $binaries['hero7_sample_nest.bin'];
        $stream = new GPMFStream($fhandle);
        $expected = 'KLVNest';

        // Act
        $stream->findNext($type);
        $klv = KLVBase::decodeFromGPMFStream($stream);

        // Assert
        $this->assertInstanceOf($expected, $klv);
        $this->assertObjectHasAttribute($type, $klv);
    }

    /** @test */
    public function klv_following_nest_is_appended_to_klv_nest_children()
    {
        // Arrange
        $fhandle = $binaries['hero7_sample_nest.bin'];
        $stream = new GPMFStream($fhandle);
        $stream->seek($stream->findNext('DEVC'));
        $nest = KLVBase::decodeFromGPMFStream($stream);

        // Act
        $klv = KLVBase::decodeFromGPMFStream($stream);

        // Assert
        $this->assertObjectHasAttribute("children", $nest);
        $this->assertContains($klv, $nest->children);
    }

    /** @test */
    //public function can_create_tree_from_
}