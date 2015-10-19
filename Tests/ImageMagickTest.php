<?php

namespace Rfd\ImageMagick\Tests;

use Rfd\ImageMagick\Image\File;
use Rfd\ImageMagick\Image\Image;
use Rfd\ImageMagick\ImageMagick;
use Rfd\ImageMagick\Operation\Factory;

abstract class ImageMagickTest extends \PHPUnit_Framework_TestCase {

    /** @var ImageMagick */
    protected $imagemagick;
    /** @var Factory */
    protected $operation_factory;

    /**
     * @return Factory
     */
    abstract protected function getOperationFactory();

    public function setUp() {
        $this->operation_factory = $this->getOperationFactory();
        $this->imagemagick = new ImageMagick($this->operation_factory);
    }

    /**
     * @param int $which
     *
     * @return Image
     */
    protected function getTestImage($which = 1) {
        $image_filename = $this->operation_factory->getProcessor()->getTempFilename('test_image_');

        // Don't use the original image.  File does file_put_contents() when you call ->setImageData().
        copy(__DIR__ . '/images/test_image_' . $which . '.png', $image_filename);

        return new File($image_filename);
    }

    protected function getTestPdf($which = 1) {
        $image_filename = $this->operation_factory->getProcessor()->getTempFilename('test_pad_');

        // Don't use the original image.  File does file_put_contents() when you call ->setImageData().
        copy(__DIR__ . '/images/test_pdf_' . $which . '.pdf', $image_filename);

        return new File($image_filename);
    }
} 