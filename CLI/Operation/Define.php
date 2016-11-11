<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

class Define extends \Rfd\ImageMagick\Operation\Define {
    /**
     * @param Image $image
     * @param string $command_line
     *
     * @return Result
     */
    public function process(Image $image, $command_line = '') {
        
        foreach ($this->definition as $key => $value) {
            $command_line .= ' -define ' . escapeshellarg($key) . '=' . escapeshellarg($value);
        }
        
        $result = new Result();
        $result->setCommandLine($command_line);
        return $result;
    }


}