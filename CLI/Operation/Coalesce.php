<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

class Coalesce extends \Rfd\ImageMagick\Operation\Coalesce {
    /**
     * @param Image  $image
     * @param string $command_line
     *
     * @return Result
     */
    public function process(Image $image = null, $command_line = '') {
        $result = new Result();
        $result->setCommandLine($command_line . ' -coalesce');
        return $result;
    }

}