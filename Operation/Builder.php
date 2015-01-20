<?php

namespace Rfd\ImageMagick\Operation;

use Rfd\ImageMagick\Image\Image;

/**
 * Class Builder
 * @package Rfd\ImageMagick\Operation
 *
 * @method Blur blur()
 * @method Compare compare()
 * @method Convert|Builder convert(string $format = null)
 * @method GaussianBlur gaussianBlur()
 * @method Info info()
 * @method Quality|Builder quality(int $quality = null)
 * @method Resize resize()
 * @method Slice slice()
 * @method Watermark watermark()
 */
class Builder {
    /** @var Factory */
    protected $operation_factory;

    /** @var Image */
    protected $input_image;

    /** @var Operation */
    protected $current_operation;

    public function __construct(Factory $operation_factory, Image $input_image) {
        $this->operation_factory = $operation_factory;
        $this->input_image = $input_image;
    }

    /**
     * Close the current operation, move on to the next.
     */
    public function next() {
        $this->current_operation = null;

        return $this;
    }

    public function finish(Image $output_image = null) {
        $this->next();

        $processor = $this->operation_factory->getProcessor();

        return $processor->processOperations($this->input_image, $output_image);
    }

    public function __call($method, $args) {
        if ($this->current_operation) {
            call_user_func_array(array($this->current_operation, $method), $args);
        } else {
            $operation = $this->operation_factory->getOperation($method);

            $processor = $this->operation_factory->getProcessor();
            $processor->addOperation($operation);

            if (isset($args[0]) && $operation instanceof OneShotOperation) {
                $operation->setValue($args[0]);
            } else {
                $this->current_operation = $operation;
            }
        }

        return $this;
    }
} 