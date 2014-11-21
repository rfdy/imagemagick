<?php
namespace Rfd\ImageMagick\Operation;

use Rfd\ImageMagick\Options\CommonOptions;

abstract class Resize extends Operation {
    /** @var int */
    protected $width;

    /** @var int */
    protected $height;

    /** @var string */
    protected $mode;

    /** @var string */
    protected $gravity = CommonOptions::GRAVITY_CENTER;

    /**
     * @param string $gravity
     *
     * @return $this
     */
    public function setGravity($gravity) {
        $this->gravity = $gravity;

        return $this;
    }

    /**
     * @param int $height
     *
     * @return $this
     */
    public function setHeight($height) {
        $this->height = $height;

        return $this;
    }

    /**
     * @param string $mode
     *
     * @return $this
     */
    public function setMode($mode) {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @param int $width
     *
     * @return $this
     */
    public function setWidth($width) {
        $this->width = $width;

        return $this;
    }
}