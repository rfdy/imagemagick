<?php

namespace Rfd\ImageMagick\Operation;

abstract class Define extends Operation {
    
    protected $definition = [];

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function setDefinition($key, $value) {
        $this->definition[$key] = $value;
    }

}