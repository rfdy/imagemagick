<?php

namespace Rfd\ImageMagick\Image;

class File implements Image {

    protected $filename;

    protected $image_type;

    public function __construct($filename) {
        $this->filename = $filename;
    }

    /**
     * Returns the complete image data, wherever it may have come from.
     *
     * @return string
     */
    public function getImageData() {
        return file_get_contents($this->filename);
    }

    /**
     * @param string $image_data
     *
     * @return void
     */
    public function setImageData($image_data) {
        file_put_contents($this->filename, $image_data);
    }

    public function getFilename() {
        return $this->filename;
    }
}
