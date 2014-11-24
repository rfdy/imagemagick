<?php

namespace Rfd\ImageMagick\Operation;

use Rfd\ImageMagick\Image\Image;

interface Processor {

    public function addOperation(Operation $operation);

    public function processOperations(Image $input_image, Image $output_image = null);

    public function getTempFilename($prefix, $extension = 'tmp');

    public function setOutputFormat($format);

    /**
     * @param int $quirk
     * @return bool
     */
    public function hasImageMagickQuirk($quirk);

    /**
     * @return string
     */
    public function getImageMagickVersion();
} 