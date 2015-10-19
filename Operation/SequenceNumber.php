<?php

namespace Rfd\ImageMagick\Operation;

abstract class SequenceNumber extends OneShotOperation implements OneShotHasArgument {

    protected $sequence_number = 1;

    public function setSequenceNumber($sequence_number) {
        $this->sequence_number = $sequence_number;

        return $this;
    }

    public function setValue($value) {
        $this->setSequenceNumber($value);
    }

    public function getValue() {
        return $this->sequence_number;
    }
}