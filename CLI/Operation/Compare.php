<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Exception\ImageMagickException;
use Rfd\ImageMagick\Image\File;
use Rfd\ImageMagick\Image\Image;

/**
 * @property Processor $processor
 */
class Compare extends \Rfd\ImageMagick\Operation\Compare {
    public function process(Image $image, $command_line = '') {
        if (!$this->compare_to) {
            throw new ImageMagickException('No image to compare to!');
        }

        $status = 0;
        $output = array();

        $output_file = $this->processor->getTempFilename('output_');
        $left_file = $this->processor->getTempFilename('left_');
        $right_file = $this->processor->getTempFilename('right_');

        if ($this->use_current) {
            // Use the current queue, not the given file.
            exec($command_line . ' ' . $left_file);
        } else {
            file_put_contents($left_file, $image->getImageData());
        }

        file_put_contents($right_file, $this->compare_to->getImageData());

        exec($this->processor->getImageMagickPath() . DIRECTORY_SEPARATOR .
            'compare -metric PSNR ' . escapeshellarg($left_file) . ' ' .
                                      escapeshellarg($right_file) . ' ' .
                                      escapeshellarg($output_file) . ' 2>&1',
            $output, $status);

        $result = new Result();
        $result->setCommandLine($command_line);

        if (!$status) {
            $result->setImage(new File($output_file))
                ->setExtra(implode(PHP_EOL, $output));
        }

        return $result;
    }
} 