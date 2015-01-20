<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Image\File;
use Rfd\ImageMagick\Options\CommonOptions;

class QualityTest extends CLITest {

    /**
     * @test
     */
    public function it_should_set_the_quality() {
        $test_image = $this->getTestImage();
        $output_image_filename = $this->operation_factory->getProcessor()->getTempFilename('quality_');
        $output_image = new File($output_image_filename);

        $this->imagemagick->getOperationBuilder($test_image)
            ->quality(10)
            ->convert(CommonOptions::FORMAT_JEPG)
            ->finish($output_image);

        $info = $this->imagemagick->getOperationBuilder($output_image)->info()->finish()->getExtra();

        $this->assertEquals(10, $info['quality']);
    }

}