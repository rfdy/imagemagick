<?php

namespace Rfd\ImageMagick\Operation;

abstract class Direct extends Operation {
    
    protected $command = '';
    
    protected $riskAcknowledged = false;
    
    public function setCommand($command) {
        $this->command = $command;
    }

    public function takeRisk() {
        $this->riskAcknowledged = true;
    }

}