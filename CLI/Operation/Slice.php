<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Exception\ImageMagickException;
use Rfd\ImageMagick\Image\Image;

class Slice extends \Rfd\ImageMagick\Operation\Slice {

    public function process(Image $image = null, $command_line = '') {
        if (!$this->width || !$this->height) {
            throw new ImageMagickException('Need both width and height to slice an image');
        }

        $command_line .= ' -background ' . escapeshellarg($this->background) . ' -gravity ' . escapeshellarg($this->gravity) . ' -extent ' . escapeshellarg($this->width . 'x' . $this->height . '+' . $this->offset_x . '+' . $this->offset_y);

        $result = new Result();
        $result->setCommandLine($command_line);

        return $result;
    }


} 