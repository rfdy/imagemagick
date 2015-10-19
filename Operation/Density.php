<?php

namespace Rfd\ImageMagick\Operation;

abstract class Density extends OneShotOperation implements OneShotHasArgument {

    protected $density;

    public function setDensity($density) {
        $this->density = $density;

        return $this;
    }

    public function setValue($value) {
        $this->setDensity($value);
    }

    public function getValue() {
        return $this->density;
    }
}