<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Image\File;

class WatermarkTest extends CLITest {

    /**
     * @test
     */
    public function it_should_watermark_images() {
        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('options_');
        $watermark_image = new File(__DIR__ . '/../images/watermark.png');
        $output_image = new File($output_filename);
        $test_image = $this->getTestImage();

        $this->imagemagick->getOperationBuilder($test_image)
            ->watermark()
            ->setWatermarkImage($watermark_image)
            ->finish($output_image);

        $expected_image = new File(__DIR__ . '/../images/expected/watermarked_test_image_1.png');

        $this->assertEquals('inf', $this->imagemagick->getOperationBuilder($output_image)->compare()->setCompareTo($expected_image)->finish()->getExtra());
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_with_no_watermark_image() {
        $this->setExpectedException('\\Rfd\\ImageMagick\\Exception\\ImageMagickException');

        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('options_');
        $output_image = new File($output_filename);
        $test_image = $this->getTestImage();

        $this->imagemagick->getOperationBuilder($test_image)
                          ->watermark()
                          ->finish($output_image);
    }
}