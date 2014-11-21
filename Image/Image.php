<?php

namespace Rfd\ImageMagick\Image;

interface Image {
    /**
     * Returns the complete image data, wherever it may have come from.
     *
     * @return string
     */
    public function getImageData();

    /**
     * @param string $image_data
     *
     * @return void
     */
    public function setImageData($image_data);

}
