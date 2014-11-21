<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Exception\ImageMagickException;
use Rfd\ImageMagick\Image\Image;
use Rfd\ImageMagick\Options\CommonOptions;

class Convert extends \Rfd\ImageMagick\Operation\Convert {

    public function process(Image $image, $command_line = '') {
        if (!$this->format) {
            throw new ImageMagickException('Can\'t change format to nothing!!');
        }

        // Sneaky!  Eat my own dog food to get in the image information.
        $processor = clone $this->processor;
        $processor->addOperation(new Info());
        $info = $processor->processOperations($image)->getExtra();

        $from = 'unknown';

        switch ($info['type']) {
            case 'JPEG':
                $from = CommonOptions::FORMAT_JPG;
                break;
            case 'GIF':
                $from = CommonOptions::FORMAT_GIF;
                break;
            case 'PNG':
                $from = CommonOptions::FORMAT_PNG;
                break;
        }

        if ($from != $this->format) {
            $this->processor->setOutputFormat($this->format);
        }

        $result = new Result();
        $result->setCommandLine($command_line);

        return $result;
    }


} 