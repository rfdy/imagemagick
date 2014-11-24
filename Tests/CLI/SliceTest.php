<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Image\File;
use Rfd\ImageMagick\Image\Image;
use Rfd\ImageMagick\Options\CommonOptions;

class SliceTest extends CLITest {

    /**
     * @test
     */
    public function it_should_slice_relative_to_gravity() {
        $test_image = $this->getTestImage();
        $output_image_filename = $this->operation_factory->getProcessor()->getTempFilename('output_');
        $output_image = new File($output_image_filename);

        $this->doTestGravity($test_image, $output_image, CommonOptions::GRAVITY_NORTHWEST);

        $this->doTestGravity($test_image, $output_image, CommonOptions::GRAVITY_NORTH);

        $this->doTestGravity($test_image, $output_image, CommonOptions::GRAVITY_NORTHEAST);

        $this->doTestGravity($test_image, $output_image, CommonOptions::GRAVITY_WEST);

        $this->doTestGravity($test_image, $output_image, CommonOptions::GRAVITY_CENTER);

        $this->doTestGravity($test_image, $output_image, CommonOptions::GRAVITY_EAST);

        $this->doTestGravity($test_image, $output_image, CommonOptions::GRAVITY_SOUTHWEST);

        $this->doTestGravity($test_image, $output_image, CommonOptions::GRAVITY_SOUTH);

        $this->doTestGravity($test_image, $output_image, CommonOptions::GRAVITY_SOUTHEAST);
    }

    /**
     * @test
     */
    public function it_should_slice_with_offset() {
        $test_image = $this->getTestImage();
        $output_image_filename = $this->operation_factory->getProcessor()->getTempFilename('output_');
        $output_image = new File($output_image_filename);

        $this->imagemagick->getOperationBuilder($test_image)
                          ->slice()
                          ->setWidth(100)->setHeight(100)
                          ->setGravity(CommonOptions::GRAVITY_CENTER)
                          ->setOffsetX(10)
                          ->setOffsetY(10)
                          ->finish($output_image);

        $this->assertEquals('inf', $this->imagemagick->getOperationBuilder($output_image)
                                                    ->compare()
                                                    ->setCompareTo(new File(__DIR__ . '/../images/expected/slice_100x100_10_10_gravity_center.png'))
                                                    ->finish()->getExtra());
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_when_no_height_is_given() {
        $this->setExpectedException('\\Rfd\\ImageMagick\\Exception\\ImageMagickException');

        $test_image = $this->getTestImage();
        $output_image_filename = $this->operation_factory->getProcessor()->getTempFilename('output_');
        $output_image = new File($output_image_filename);

        $this->imagemagick->getOperationBuilder($test_image)
                          ->slice()
                          ->setWidth(100)
                          ->setGravity(CommonOptions::GRAVITY_CENTER)
                          ->setOffsetX(10)
                          ->setOffsetY(10)
                          ->finish($output_image);
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_when_no_width_is_given() {
        $this->setExpectedException('\\Rfd\\ImageMagick\\Exception\\ImageMagickException');

        $test_image = $this->getTestImage();
        $output_image_filename = $this->operation_factory->getProcessor()->getTempFilename('output_');
        $output_image = new File($output_image_filename);

        $this->imagemagick->getOperationBuilder($test_image)
                          ->slice()
                          ->setHeight(100)
                          ->setGravity(CommonOptions::GRAVITY_CENTER)
                          ->setOffsetX(10)
                          ->setOffsetY(10)
                          ->finish($output_image);
    }



    /**
     * @param Image $test_image
     * @param Image $output_image
     * @param       $gravity
     */
    protected function doTestGravity($test_image, $output_image, $gravity) {
        $this->imagemagick->getOperationBuilder($test_image)
                          ->slice()
                          ->setWidth(100)->setHeight(100)->setGravity($gravity)
                          ->finish($output_image);

        $result = $this->imagemagick->getOperationBuilder($output_image)
                                   ->compare()
                                   ->setCompareTo(new File(__DIR__ . '/../images/expected/slice_100x100_gravity_' . $gravity . '.png'))
                                   ->finish();

        $value = $result->getExtra();

        // Different versions of IM will be ever so slightly different
        // due JPEG compression and such.  Check for exactness or REALLLY closeness.
        $this->assertTrue($value == 'inf' || $value >= 40, "Gravity {$gravity} failed");
    }


} 