<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Image\File;

class StripTest extends CLITest {

    /**
     * @test
     */
    public function it_should_strip_all_profile_information() {
        $input_image = $this->getTestImage(5);
        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('strip_');
        $output_image = new File($output_filename);

        $this->imagemagick->getOperationBuilder($input_image)
            ->strip()
            ->finish($output_image);

        $this->assertNotEquals(strlen($input_image->getImageData()), strlen($output_image->getImageData()));
    }

}