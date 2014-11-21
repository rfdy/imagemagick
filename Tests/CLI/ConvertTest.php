<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Image\File;
use Rfd\ImageMagick\Options\CommonOptions;

class ConvertTest extends CLITest {

    /**
     * @test
     */
    public function it_should_convert_to_png() {
        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('convert_');
        $output_image = new File($output_filename);

        $this->imagemagick->getOperationBuilder($this->getTestImage(4)) // test_image_4.jpg is actually a gif.  Shhhh.
            ->convert()
            ->setFormat(CommonOptions::FORMAT_PNG)
            ->finish($output_image);

        $info_result = $this->imagemagick->getOperationBuilder($output_image)->info()->finish();

        $this->assertEquals(array(
            'width' => 300,
            'height' => 300,
            'depth' => 8,
            'type' => 'PNG'
        ), $info_result->getExtra());
    }

    /**
     * @test
     */
    public function it_should_convert_to_gif() {
        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('convert_');
        $output_image = new File($output_filename);

        $this->imagemagick->getOperationBuilder($this->getTestImage())
                          ->convert()
                          ->setFormat(CommonOptions::FORMAT_GIF)
                          ->finish($output_image);

        $info_result = $this->imagemagick->getOperationBuilder($output_image)->info()->finish();

        $this->assertEquals(array(
            'width' => 300,
            'height' => 300,
            'depth' => 8,
            'type' => 'GIF'
        ), $info_result->getExtra());
    }

    /**
     * @test
     */
    public function it_should_convert_to_jpg() {
        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('convert_');
        $output_image = new File($output_filename);

        $this->imagemagick->getOperationBuilder($this->getTestImage(3)) // test_image_3.jpg is actually a png.  Shhh.
                          ->convert()
                          ->setFormat(CommonOptions::FORMAT_JPG)
                          ->finish($output_image);

        $info_result = $this->imagemagick->getOperationBuilder($output_image)->info()->finish();

        $this->assertEquals(array(
            'width' => 300,
            'height' => 300,
            'depth' => 8,
            'type' => 'JPEG'
        ), $info_result->getExtra());
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_when_no_format_is_given() {
        $this->setExpectedException('\\Rfd\\ImageMagick\\Exception\\ImageMagickException');

        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('convert_');
        $output_image = new File($output_filename);

        $this->imagemagick->getOperationBuilder($this->getTestImage())
                          ->convert()
                          ->finish($output_image);
    }
} 