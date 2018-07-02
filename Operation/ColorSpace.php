<?php

namespace Rfd\ImageMagick\Operation;

abstract class ColorSpace extends OneShotOperation implements OneShotHasArgument {

    /** @var string */
    protected $color_space;

    /**
     * @param string $color_space
     *
     * @return $this
     */
    public function setColorSpace($color_space) {
        $this->color_space = $color_space;

        return $this;
    }

    /**
     * @param mixed $value
     *
     * @return void
     */
    public function setValue($value) {
        $this->setColorSpace($value);
    }


}
