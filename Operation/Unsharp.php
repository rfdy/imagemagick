<?php

namespace Rfd\ImageMagick\Operation;

abstract class Unsharp extends Operation {

    protected $radius = 0;

    protected $sigma = 1.0;
    
    protected $gain = 1.0;
    
    protected $threshold = 0.05;

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
    
     /**
     * @param float $gain
     *
     * @return $this
     */
    public function setGain($gain) {
        $this->gain = (float)$gain;
    }
    
     /**
     * @param float $threshold
     *
     * @return $this
     */
    public function setThreshold($threshold) {
        $this->threshold = (float)$threshold;
    }
}