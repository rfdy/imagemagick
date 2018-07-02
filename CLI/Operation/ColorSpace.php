<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

class ColorSpace extends \Rfd\ImageMagick\Operation\ColorSpace {
    /**
     * @param Image  $image
     * @param string $command_line
     *
     * @return Result
     */
    public function process(Image $image, $command_line = '') {
        $result = new Result();
        $result->setCommandLine($command_line . ' -colorspace ' . escapeshellarg($this->color_space));
        return $result;
    }

}
