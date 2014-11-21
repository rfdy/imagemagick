<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Operation\Factory;
use Rfd\ImageMagick\Tests\ImageMagickTest;

abstract class CLITest extends ImageMagickTest {
    /**
     * @return Factory
     */
    protected function getOperationFactory() {
        return new \Rfd\ImageMagick\CLI\Operation\Factory();
    }
}