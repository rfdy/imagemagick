<?php

namespace Rfd\ImageMagick\Operation;

abstract class OneShotOperation extends Operation {
    /**
     * @param mixed $value
     *
     * @return Builder
     */
    abstract public function setValue($value);
}