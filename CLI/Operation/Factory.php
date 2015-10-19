<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Exception\ImageMagickException;
use Rfd\ImageMagick\Operation\Operation;

class Factory implements \Rfd\ImageMagick\Operation\Factory {

    protected $processor;

    public function getOperation($operation_name, $arguments = array()) {
        switch ($operation_name) {
            case Operation::ADD_PROFILE:
                return new AddProfile();
            case Operation::BLUR:
                return new Blur();
            case Operation::COMPARE:
                return new Compare();
            case Operation::CONVERT:
                return new Convert();
            case Operation::DENSITY:
                return new Density();
            case Operation::GAUSSIAN_BLUR:
                return new GaussianBlur();
            case Operation::INFO:
                return new Info();
            case Operation::QUALITY:
                return new Quality();
            case Operation::REMOVE_PROFILE:
                return new RemoveProfile();
            case Operation::RESIZE:
                return new Resize();
            case Operation::SEQUENCE_NUMBER:
                return new SequenceNumber();
            case Operation::SLICE:
                return new Slice();
            case Operation::STRIP:
                return new Strip();
            case Operation::WATERMARK:
                return new Watermark();
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