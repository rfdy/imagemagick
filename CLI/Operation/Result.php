<?php

namespace Rfd\ImageMagick\CLI\Operation;

class Result extends \Rfd\ImageMagick\Operation\Result {
    /** @var string */
    protected $command_line;

    /**
     * @return string
     */
    public function getCommandLine() {
        return $this->command_line;
    }

    /**
     * @param string $command_line
     *
     * @return $this
     */
    public function setCommandLine($command_line) {
        $this->command_line = $command_line;

        return $this;
    }
} 