<?php

namespace Rfd\ImageMagick\Tests\CLI;

use Rfd\ImageMagick\Image\File;
use Rfd\ImageMagick\Options\CommonOptions;

class ResizeTest extends CLITest {

    /**
     * @test
     */
    public function it_should_resize_images_by_width() {
        $temp_filename = $this->operation_factory->getProcessor()->getTempFilename('resize_');

        $output_file = new File($temp_filename);

        $this->imagemagick->getOperationBuilder($this->getTestImage())->resize()
            ->setWidth(100)
            ->finish($output_file);

        $info_result = $this->imagemagick->getOperationBuilder($output_file)->info()->finish();

        $this->assertEquals(array(
            'width' => 100,
            'height' => 100,
            'depth' => 8,
            'type' => 'PNG',
            'quality' => 0
        ), $info_result->getExtra());
    }

    /**
     * @test
     */
    public function it_should_resize_images_by_height() {
        $temp_filename = $this->operation_factory->getProcessor()->getTempFilename('resize_');

        $output_file = new File($temp_filename);

        $this->imagemagick->getOperationBuilder($this->getTestImage())
            ->resize()
            ->setHeight(50)
            ->finish($output_file);

        $info_result = $this->imagemagick->getOperationBuilder($output_file)->info()->finish();

        $this->assertEquals(array(
            'width' => 50,
            'height' => 50,
            'depth' => 8,
            'type' => 'PNG',
            'quality' => 0
        ), $info_result->getExtra());
    }

    /**
     * @test
     */
    public function it_should_only_shrink_larger() {
        $temp_filename = $this->operation_factory->getProcessor()->getTempFilename('resize_');

        $output_file = new File($temp_filename);

        $this->imagemagick->getOperationBuilder($this->getTestImage())
            ->resize()
            ->setWidth(500)
            ->setHeight(500)
            ->setMode(CommonOptions::MODE_ONLY_SHRINK_LARGER)
            ->finish($output_file);

        $info_result = $this->imagemagick->getOperationBuilder($output_file)->info()->finish();

        $this->assertEquals(array(
            'width' => 300,
            'height' => 300,
            'depth' => 8,
            'type' => 'PNG',
            'quality' => 0
        ), $info_result->getExtra());
    }

    /**
     * @test
     */
    public function it_should_scale_down_with_fill_or_fit() {
        $temp_filename = $this->operation_factory->getProcessor()->getTempFilename('resize_');

        $output_file = new File($temp_filename);

        $this->imagemagick->getOperationBuilder($this->getTestImage())
                          ->resize()
                          ->setWidth(200)
                          ->setHeight(100)
                          ->setMode(CommonOptions::MODE_FILL_AREA_OR_FIT)
                          ->finish($output_file);

        $info_result = $this->imagemagick->getOperationBuilder($output_file)->info()->finish();

        $this->assertEquals(array(
            'width' => 200,
            'height' => 200,
            'depth' => 8,
            'type' => 'PNG',
            'quality' => 0
        ), $info_result->getExtra());
    }

    /**
     * @test
     */
    public function it_should_fit_with_fill_or_fit() {
        $temp_filename = $this->operation_factory->getProcessor()->getTempFilename('resize_');

        $output_file = new File($temp_filename);

        $this->imagemagick->getOperationBuilder($this->getTestImage())
            // Resize it first; that way it triggers the "Fit" section.
                          ->slice()
                          ->setWidth(299)
                          ->setHeight(200)
                          ->setGravity(CommonOptions::GRAVITY_CENTER)
                          ->next()
                          ->resize()
                          ->setWidth(400)
                          ->setHeight(100)
                          ->setGravity(CommonOptions::GRAVITY_CENTER)
                          ->setMode(CommonOptions::MODE_FILL_AREA_OR_FIT)
                          ->finish($output_file);

        $info_result = $this->imagemagick->getOperationBuilder($output_file)->info()->finish();

        $this->assertEquals(array(
            'width' => 150,
            'height' => 100,
            'depth' => 8,
            'type' => 'PNG',
            'quality' => 0
        ), $info_result->getExtra());
    }

    /**
     * @test
     */
    public function it_should_do_nothing_if_the_requested_size_is_the_current_size() {
        $temp_filename = $this->operation_factory->getProcessor()->getTempFilename('resize_');

        $output_file = new File($temp_filename);
        $test_image = $this->getTestImage();

        $this->imagemagick->getOperationBuilder($test_image)
                          ->resize()
                          ->setWidth(300)
                          ->setHeight(300)
                          ->setGravity(CommonOptions::GRAVITY_CENTER)
                          ->setMode(CommonOptions::MODE_FILL_AREA_OR_FIT)
                          ->finish($output_file);

        $info_result = $this->imagemagick->getOperationBuilder($output_file)->info()->finish();

        $this->assertEquals(array(
            'width' => 300,
            'height' => 300,
            'depth' => 8,
            'type' => 'PNG',
            'quality' => 0
        ), $info_result->getExtra());

        $compare_result = $this->imagemagick->getOperationBuilder($output_file)
            ->compare()
            ->setCompareTo($test_image)
            ->finish();

        $this->assertEquals('inf', $compare_result->getExtra());
    }

    /**
     * @test
     */
    public function it_should_resize_absolutely() {
        $temp_filename = $this->operation_factory->getProcessor()->getTempFilename('resize_absolute_');

        $output_file = new File($temp_filename);
        $test_image = $this->getTestImage();

        $this->imagemagick->getOperationBuilder($test_image)
                          ->resize()
                          ->setWidth(100)
                          ->setHeight(500)
                          ->setGravity(CommonOptions::GRAVITY_CENTER)
                          ->setMode(CommonOptions::MODE_RESIZE_ABSOLUTE)
                          ->finish($output_file);

        $info_result = $this->imagemagick->getOperationBuilder($output_file)->info()->finish();

        $this->assertEquals(array(
            'width' => 100,
            'height' => 500,
            'depth' => 8,
            'type' => 'PNG',
            'quality' => 0
        ), $info_result->getExtra());
    }
} 