<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

class RemoveProfile extends \Rfd\ImageMagick\Operation\RemoveProfile {
    /**
     * @param Image  $image
     * @param string $command_line
     *
     * @return Result
     */
    public function process(Image $image = null, $command_line = '') {
        $result = new Result();
        $result->setCommandLine($command_line . ' +profile ' . escapeshellarg($this->profile));
        return $result;
    }

}