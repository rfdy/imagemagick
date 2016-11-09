<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

class Unsharp extends \Rfd\ImageMagick\Operation\Unsharp {
    /**
     * @param Image $image
     * @param string $command_line
     *
     * @return Result
     */
    public function process(Image $image, $command_line = '') {
        $result = new Result();

        $result->setCommandLine($command_line . ' -unsharp ' . escapeshellarg($this->radius . 'x' . $this->sigma . '+' . $this->gain . '+' . $this->threshold));

        return $result;
    }

}