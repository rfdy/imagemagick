<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Image\File;
use Rfd\ImageMagick\Options\CommonOptions;

class DensityTest extends CLITest {

    /** @test */
    public function it_should_allow_the_user_to_specify_pixel_density() {
        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('pdf_');
        $output_image = new File($output_filename);

        $this->imagemagick->getOperationBuilder($this->getTestPdf(1))
            ->convert(CommonOptions::FORMAT_PNG)
            ->sequenceNumber(1)
            ->density(300)
            ->finish($output_image);

        $info_result = $this->imagemagick->getOperationBuilder($output_image)->info()->finish();

        $this->assertEquals(array(
            'width' => 2550,
            'height' => 3300,
            'depth' => 8,
            'type' => 'PNG',
            'quality' => 0
        ), $info_result->getExtra());
    }

    /** @test */
    public function it_should_throw_an_exception_if_density_is_not_an_integer() {
        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('pdf_');
        $output_image = new File($output_filename);

        $this->setExpectedException('Rfd\\ImageMagick\\Exception\\ImageMagickException', 'Density was not an integer');

        $this->imagemagick->getOperationBuilder($this->getTestPdf(1))
            ->convert(CommonOptions::FORMAT_PNG)
            ->sequenceNumber(1)
            ->density('a lot')
            ->finish($output_image);
    }

}