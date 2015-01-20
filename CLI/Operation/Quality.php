<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

class Quality extends \Rfd\ImageMagick\Operation\Quality {
    /**
     * @param Image $image
     * @param string $command_line
     *
     * @return Result
     */
    public function process(Image $image, $command_line = '') {
        $result = new Result();

        $result->setCommandLine($command_line . ' -quality ' . escapeshellarg($this->quality));

        return $result;
    }


}