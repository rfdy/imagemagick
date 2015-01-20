<?php

namespace Rfd\ImageMagick\Tests\CLI;



class InfoTest extends CLITest {
    /**
     * @test
     */
    public function it_should_give_the_image_info() {
        $info_result = $this->imagemagick->getOperationBuilder($this->getTestImage())->info()->finish();

        $this->assertEquals(array(
            'width' => 300,
            'height' => 300,
            'depth' => 8,
            'type' => 'PNG',
            'quality' => 0
        ), $info_result->getExtra());
    }

} 