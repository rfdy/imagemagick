<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

class Filter extends \Rfd\ImageMagick\Operation\Filter {
    /**
     * @param Image $image
     * @param string $command_line
     *
     * @return Result
     */
    public function process(Image $image, $command_line = '') {
        $result = new Result();

        $result->setCommandLine($command_line . ' -filter ' . escapeshellarg($this->filter));

        return $result;
    }


}