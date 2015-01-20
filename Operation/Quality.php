<?php

namespace Rfd\ImageMagick\Operation;

abstract class Quality extends OneShotOperation implements OneShotHasArgument {
    protected $quality = 80;

    public function setValue($value) {
        $this->quality = $value;
    }

    /**
     * @param int $quality
     * @return $this
     */
    public function setQuality($quality) {
        $this->setValue($quality);
    }
}