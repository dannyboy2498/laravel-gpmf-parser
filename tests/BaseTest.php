<?php

namespace Dan\GPMF\Tests;

use phpDocumentor\Reflection\Types\Void_;
use PHPUnit\Framework\TestCase;
use Tightenco\Collect\Support\Collection;

class BaseTest extends TestCase
{
    protected $binaries;

    public function setUp(): void
    {
        $this->binaries = new Collection();
        $this->preloadBinaryFixtures();
    }

    private function preloadBinaryFixtures()
    {
        $directory = __DIR__ . '/Fixtures/Binaries';
        $files = array_diff(scandir($directory), ['.', '..']);

        foreach ($files as $filename) {
            $stream = fopen("{$directory}/{$filename}", 'rb');
            $this->binaries->put($filename, $stream);
        }
    }

    public function tearDown(): void
    {
        $this->binaries->map(function ($handle) {
            fclose($handle);
        });
    }
}
