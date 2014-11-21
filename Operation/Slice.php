<?php
namespace Rfd\ImageMagick\Operation;

abstract class Slice extends Operation {
    /** @var int */
    protected $width;

    /** @var int */
    protected $height;

    /** @var string */
    protected $gravity;

    /** @var int */
    protected $offset_x = 0;

    /** @var int */
    protected $offset_y = 0;

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
     * @param int $width
     *
     * @return $this
     */
    public function setWidth($width) {
        $this->width = $width;

        return $this;
    }

    /**
     * @param int $offset_x
     *
     * @return $this
     */
    public function setOffsetX($offset_x) {
        $this->offset_x = $offset_x;

        return $this;
    }

    /**
     * @param int $offset_y
     *
     * @return $this
     */
    public function setOffsetY($offset_y) {
        $this->offset_y = $offset_y;

        return $this;
    }
}