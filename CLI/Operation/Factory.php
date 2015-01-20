<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Exception\ImageMagickException;
use Rfd\ImageMagick\Operation\Operation;

class Factory implements \Rfd\ImageMagick\Operation\Factory {

    protected $processor;

    public function getOperation($operation_name, $arguments = array()) {
        switch ($operation_name) {
            case Operation::CONVERT:
                return new Convert();
            case Operation::RESIZE:
                return new Resize();
            case Operation::SLICE:
                return new Slice();
            case Operation::WATERMARK:
                return new Watermark();
            case Operation::COMPARE:
                return new Compare();
            case Operation::INFO:
                return new Info();
            case Operation::BLUR:
                return new Blur();
            case Operation::GAUSSIAN_BLUR:
                return new GaussianBlur();
            default:
                throw new ImageMagickException('Unknown operation: ' . $operation_name);
                break;
        }
    }

    /**
     * @return Processor
     */
    public function getProcessor() {
        if (!$this->processor) {
            $this->processor = $this->getNewProcessor();
        }

        return $this->processor;
    }

    /**
     * @return Processor
     */
    public function getNewProcessor() {
        return new Processor();
    }

    public function __clone() {
        $this->processor = null;
    }
} 