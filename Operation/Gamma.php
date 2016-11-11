<?php

namespace Rfd\ImageMagick\Operation;

abstract class Gamma extends OneShotOperation implements OneShotHasArgument {
    protected $gamma = 1;

    public function setValue($value) {
        $this->gamma = (float) $value;
    }

    /**
     * @param int gamma
     * @return $this
     */
    public function setGamma($gamma) {
        $this->setValue($gamma);
    }
}