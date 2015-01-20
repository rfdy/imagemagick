<?php

namespace Rfd\ImageMagick\Operation;

abstract class Blur extends Operation {

    protected $radius;

    protected $sigma;

    /**
     * @param int $radius
     *
     * @return $this
     */
    public function setRadius($radius) {
        $this->radius = (int)$radius;
    }

    /**
     * @param float $sigma
     *
     * @return $this
     */
    public function setSigma($sigma) {
        $this->sigma = (float)$sigma;
    }
}