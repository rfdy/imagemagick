<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;
use Rfd\ImageMagick\Options\CommonOptions;

/**
 * @property Processor $processor
 */
class Extent extends \Rfd\ImageMagick\Operation\Extent {
    public function process(Image $image, $command_line = '') {
       
        $command_line .= ' -gravity ' . escapeshellarg($this->gravity);
        $command_line .= ' -extent ' . escapeshellarg($this->width . 'x' . $this->height);

        $result = new Result();
        $result->setCommandLine($command_line);

        return $result;
    }
} 