<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Image\File;
use Rfd\ImageMagick\Options\CommonOptions;

class CompareTest extends CLITest {

    /**
     * @test
     */
    public function it_should_compare_images() {
        $difference = $this->imagemagick
            ->getOperationBuilder($this->getTestImage(1))
            ->compare()
            ->setCompareTo($this->getTestImage(2))
            ->finish();

        $this->assertTrue($difference->getExtra() > 3.5 && $difference->getExtra() < 3.6);
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_if_you_forget_the_compare_to() {
        $this->setExpectedException('\\Rfd\\ImageMagick\\Exception\\ImageMagickException');
        $this->imagemagick
            ->getOperationBuilder($this->getTestImage(1))
            ->compare()
            ->finish();
    }

    /**
     * @test
     */
    public function it_should_be_able_to_use_the_current_context() {
        $difference = $this->imagemagick
            ->getOperationBuilder($this->getTestImage(1))
            ->slice()
            ->setWidth(100)->setHeight(100)
            ->setGravity(CommonOptions::GRAVITY_CENTER)
            ->setOffsetX(10)->setOffsetY(10)
            ->next()
            ->compare()
            ->useCurrent()
            ->setCompareTo(new File(__DIR__ . '/../images/expected/slice_100x100_10_10_gravity_center.png'))
            ->finish();

        $this->assertEquals('inf', $difference->getExtra());
    }
}
