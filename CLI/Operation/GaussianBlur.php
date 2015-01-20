<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

class GaussianBlur extends \Rfd\ImageMagick\Operation\GaussianBlur {
    /**
     * @param Image $image
     * @param string $command_line
     *
     * @return Result
     */
    public function process(Image $image, $command_line = '') {
        $result = new Result();

        $result->setCommandLine($command_line . ' -gaussian-blur ' . escapeshellarg($this->radius . 'x' . $this->sigma));

        return $result;
    }
}