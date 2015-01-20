<?php

namespace Rfd\ImageMagick\Tests\CLI;

class BuilderTest extends CLITest {
    /**
     * @test
     */
    public function it_should_throw_an_exception_when_operation_is_unknown() {
        $this->setExpectedException('\\Rfd\\ImageMagick\\Exception\\ImageMagickException');

        $this->imagemagick->getOperationBuilder($this->getTestImage())->foo()->finish();
    }
}