<?php
namespace Rfd\ImageMagick\Operation;

use Rfd\ImageMagick\Image\Image;

abstract class Watermark extends Operation {
    /** @var Image */
    protected $watermark_image;

    /**
     * @param Image $image
     * @return $this
     */
    public function setWatermarkImage(Image $image) {
        $this->watermark_image = $image;

        return $this;
    }
}