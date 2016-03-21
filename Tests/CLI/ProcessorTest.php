<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\CLI\Operation\Processor;

class ProcessorTest extends CLITest {

    /** @test */
    public function it_should_find_imagemagick() {
        $processor = new Processor();
        $this->assertNotEmpty($processor->getImageMagickPath());
    }

    /** @test */
    public function it_should_throw_an_exception_when_imagemagick_is_not_found() {
        $processor = new Processor();
        $processor->setImageMagickBinaryName('TOTALLYNOTCONVERT');

        $this->setExpectedException('Rfd\ImageMagick\Exception\ImageMagickException');

        $processor->getImageMagickPath();
    }
}
