<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Image\File;

class RemoveProfileTest extends CLITest {
    /**
     * @test
     */
    public function it_should_remove_profiles_from_images() {
        $input_image = $this->getTestImage(5);
        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('remove_profile_');
        $output_image = new File($output_filename);

        $this->imagemagick->getOperationBuilder($input_image)
                          ->removeProfile('icc')
                          ->finish($output_image);

        $this->assertEquals(40735, strlen($output_image->getImageData()));
    }

    /**
     * @test
     */
    public function it_should_remove_wildcard_profiles_from_images() {
        $input_image = $this->getTestImage(5);
        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('remove_profile_');
        $output_image = new File($output_filename);

        $this->imagemagick->getOperationBuilder($input_image)
                          ->removeProfile('!exif,*')
                          ->finish($output_image);

        $this->assertEquals(40735, strlen($output_image->getImageData()));
    }
}