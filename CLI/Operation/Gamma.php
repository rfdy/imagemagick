<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

class Gamma extends \Rfd\ImageMagick\Operation\Gamma {
    /**
     * @param Image $image
     * @param string $command_line
     *
     * @return Result
     */
    public function process(Image $image = null, $command_line = '') {
        $result = new Result();

        $result->setCommandLine($command_line . ' -gamma ' . escapeshellarg($this->gamma));

        return $result;
    }


}