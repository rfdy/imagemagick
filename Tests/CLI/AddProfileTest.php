<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Image\File;

class AddProfileTest extends CLITest {

    /**
     * @test
     */
    public function it_should_add_profiles_to_images() {
        $input_image = $this->getTestImage(5);
        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('add_profile_');
        $output_image = new File($output_filename);

        $this->imagemagick->getOperationBuilder($input_image)
                          ->strip()
                          ->addProfile(__DIR__ . '/../images/sRGB_v4_ICC_preference.icc')
                          ->finish($output_image);

        $this->assertEquals(101609, strlen($output_image->getImageData()));
    }
}