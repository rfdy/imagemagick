<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

class Border extends \Rfd\ImageMagick\Operation\Border {
    /**
     * @param Image $image
     * @param string $command_line
     *
     * @return Result
     */
    public function process(Image $image, $command_line = '') {
        $result = new Result();

        $result->setCommandLine($command_line . ' -bordercolor ' . escapeshellarg($this->color)
            . ' -border ' . escapeshellarg($this->leftRight . 'x' . $this->topBottom));

        return $result;
    }
}