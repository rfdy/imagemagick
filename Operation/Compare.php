<?php
namespace Rfd\ImageMagick\Operation;

use Rfd\ImageMagick\Image\Image;

abstract class Compare extends InstantOperation {
    /** @var Image */
    protected $compare_to;

    /** @var bool  */
    protected $use_current = false;

    /**
     * @param Image $image
     * @return $this
     */
    public function setCompareTo(Image $image) {
        $this->compare_to = $image;

        return $this;
    }

    /**
     * @return $this
     */
    public function useCurrent() {
        $this->use_current = true;

        return $this;
    }
}