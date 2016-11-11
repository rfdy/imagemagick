<?php
namespace Rfd\ImageMagick\Operation;

use Rfd\ImageMagick\Options\CommonOptions;

abstract class Border extends Operation {
    /** @var int */
    protected $topBottom;

    /** @var int */
    protected $leftRight;

    /** @var string */
    protected $color = "#DFDFDF";

    /**
     * @param int $topBottom
     *
     * @return $this
     */
    public function setTopBottom($topBottom) {
        $this->topBottom = $topBottom;

        return $this;
    }

    /**
     * @param string $color
     *
     * @return $this
     */
    public function setColor($color) {
        $this->color = $color;

        return $this;
    }

    /**
     * @param int $leftRight
     *
     * @return $this
     */
    public function setLeftRight($leftRight) {
        $this->leftRight = $leftRight;

        return $this;
    }
}