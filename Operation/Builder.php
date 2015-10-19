<?php

namespace Rfd\ImageMagick\Operation;

use Rfd\ImageMagick\Image\Image;

/**
 * Class Builder
 * @package Rfd\ImageMagick\Operation
 *
 * @method AddProfile|Builder addProfile(string $profile_filename = null)
 * @method Blur blur()
 * @method Compare compare()
 * @method Convert|Builder convert(string $format = null)
 * @method Density|Builder density(int $density)
 * @method GaussianBlur gaussianBlur()
 * @method Info info()
 * @method Quality|Builder quality(int $quality = null)
 * @method RemoveProfile|Builder removeProfile(string $profile_name = null)
 * @method Resize resize()
 * @method SequenceNumber|Builder sequenceNumber(int $sequence_number)
 * @method Slice slice()
 * @method Builder strip()
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

            if ($operation instanceof OneShotHasArgument && isset($args[0])) {
                // If it's a one-shot with argument, and there's an argument.
                $operation->setValue($args[0]);
            } elseif (!($operation instanceof OneShotOperation) || ($operation instanceof OneShotHasArgument && !isset($args[0]))) {
                // If it's not a one-shot, or if it's a one-shot but no arguments were passed...
                $this->current_operation = $operation;
            }
            // else: If it's a one-shot without arguments, it just gets added (e.g. Strip)
        }

        return $this;
    }
} 