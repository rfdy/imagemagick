<?php
namespace Rfd\ImageMagick\Operation;

abstract class Convert extends Operation {

    protected $format;

    /**
     * @param string $format CommonOptions::FORMAT_*
     */
    public function setFormat($format) {
        $this->format = $format;
    }
}