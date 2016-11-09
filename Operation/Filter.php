<?php

namespace Rfd\ImageMagick\Operation;

abstract class Filter extends OneShotOperation implements OneShotHasArgument {
    
    protected $filter = '';

    public function setValue($value) {
        $this->filter = $value;
    }

    /**
     * @param int $filter
     * @return $this
     */
    public function setFilter($filter) {
        $this->setValue($filter);
    }
}