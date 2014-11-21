<?php

namespace Rfd\ImageMagick;

use Rfd\ImageMagick\Image\Image;
use Rfd\ImageMagick\Operation\Builder;
use Rfd\ImageMagick\Operation\Factory;

class ImageMagick {
    /** @var Factory */
    protected $operation_factory;

    public function __construct(Factory $operation_factory) {
        $this->operation_factory = $operation_factory;
    }

    public function getOperationBuilder(Image $input_image) {
        return new Builder(clone $this->operation_factory, $input_image);
    }
}
