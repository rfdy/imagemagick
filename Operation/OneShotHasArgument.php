<?php


namespace Rfd\ImageMagick\Operation;


interface OneShotHasArgument {
    /**
     * @param mixed $value
     *
     * @return void
     */
    public function setValue($value);
}