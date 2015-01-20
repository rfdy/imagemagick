<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

class Strip extends \Rfd\ImageMagick\Operation\Strip {
    /**
     * @param Image  $image
     * @param string $command_line
     *
     * @return Result
     */
    public function process(Image $image, $command_line = '') {
        $result = new Result();
        $result->setCommandLine($command_line . ' -strip');
        return $result;
    }

}