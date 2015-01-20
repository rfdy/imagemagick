<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

class AddProfile extends \Rfd\ImageMagick\Operation\AddProfile {
    /**
     * @param Image  $image
     * @param string $command_line
     *
     * @return Result
     */
    public function process(Image $image, $command_line = '') {
        $result = new Result();
        $result->setCommandLine($command_line . ' -profile ' . escapeshellarg($this->profile));
        return $result;
    }

}