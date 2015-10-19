<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Image\File;
use Rfd\ImageMagick\Options\CommonOptions;

class SequenceNumberTest extends CLITest {

    /** @test */
    public function it_should_select_a_specific_sequence_number_from_the_image() {
        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('pdf_');
        $output_image = new File($output_filename);

        $this->imagemagick->getOperationBuilder($this->getTestPdf(1))
            ->convert(CommonOptions::FORMAT_PNG)
            ->sequenceNumber(1)
            ->finish($output_image);

        $info_result = $this->imagemagick->getOperationBuilder($output_image)->info()->finish();

        $this->assertEquals(array(
            'width' => 612,
            'height' => 792,
            'depth' => 8,
            'type' => 'PNG',
            'quality' => 0
        ), $info_result->getExtra());
    }

    /** @test */
    public function it_should_throw_an_exception_if_sequence_number_is_not_an_integer() {
        $output_filename = $this->operation_factory->getProcessor()->getTempFilename('pdf_');
        $output_image = new File($output_filename);

        $this->setExpectedException('Rfd\\ImageMagick\\Exception\\ImageMagickException', 'Frame was not an integer');

        $this->imagemagick->getOperationBuilder($this->getTestPdf(1))
            ->convert(CommonOptions::FORMAT_PNG)
            ->sequenceNumber('first')
            ->finish($output_image);
    }

}