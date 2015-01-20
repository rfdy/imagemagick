<?php
namespace Rfd\ImageMagick\Operation;

abstract class Convert extends OneShotOperation implements OneShotHasArgument {

    protected $format;

    /**
     * @param string $format CommonOptions::FORMAT_*
     * @return $this
     */
    public function setFormat($format) {
        $this->format = $format;

        return $this;
    }

    public function setValue($value) {
        $this->setFormat($value);
    }
}