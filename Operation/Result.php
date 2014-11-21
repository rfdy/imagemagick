<?php

namespace Rfd\ImageMagick\Operation;

use Rfd\ImageMagick\Image\Image;

class Result {
    /** @var Image */
    protected $image;

    /** @var mixed */
    protected $extra;

    /**
     * @return mixed
     */
    public function getExtra() {
        return $this->extra;
    }

    /**
     * @param mixed $extra
     *
     * @return $this
     */
    public function setExtra($extra) {
        $this->extra = $extra;

        return $this;
    }

    /**
     * @return Image
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @param Image $image
     *
     * @return $this
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }
} 