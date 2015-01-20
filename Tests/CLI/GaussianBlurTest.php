<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Image\File;

class GaussianBlurTest extends CLITest {

    /**
     * @test
     */
    public function it_should_blur_the_image() {
        $test_image = $this->getTestImage();
        $output_image_filename = $this->operation_factory->getProcessor()->getTempFilename('gaussian_blur_');
        $output_image = new File($output_image_filename);

        $this->imagemagick->getOperationBuilder($test_image)
                          ->gaussianBlur()
                          ->setRadius(0)
                          ->setSigma(5)
                          ->finish($output_image);

        $this->assertEquals('inf', $this->imagemagick->getOperationBuilder($output_image)
                                                     ->compare()
                                                     ->setCompareTo(new File(__DIR__ . '/../images/expected/gaussian_blur_0x5.png'))
                                                     ->finish()
                                                     ->getExtra()
        );
    }
}