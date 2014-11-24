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

        $output_file = $this->processor->getTempFilename('output_');
        $left_file = $this->processor->getTempFilename('left_');
        $right_file = $this->processor->getTempFilename('right_');

        if ($this->use_current) {
            $status = 0;
            $output = array();

            // Use the current queue, not the given file.
            exec($command_line . ' ' . $left_file, $output, $status);
            if ($status) {
                throw new ImageMagickException('Could not compare images: ' . implode("\n", $output));
            }
        } else {
            file_put_contents($left_file, $image->getImageData());
        }

        file_put_contents($right_file, $this->compare_to->getImageData());

        $status = 0;
        $output = array();

        exec($this->processor->getImageMagickPath() . DIRECTORY_SEPARATOR .
            'compare -metric PSNR ' . escapeshellarg($left_file) . ' ' .
                                      escapeshellarg($right_file) . ' ' .
                                      ' -quality 100 ' . escapeshellarg($output_file) . ' 2>&1',
            $output, $status);

        if ($status == 1 && $this->processor->hasImageMagickQuirk(Processor::QUIRK_RESULT_IS_ONE_WHEN_COMPARE_FAILS)) {
            // $status > 1 means something else failed.  1 means the images weren't exactly the same.
            $status = 0;
        }

        if ($status == 0) {
            if (stripos($output[0], 'inf') !== false) {
                // IM sometimes returns 1.#INF instead of "inf".  Normalize it to what we expect.
                $output[0] = 'inf';
            }
        }

        if ($status) {
            throw new ImageMagickException('Could not compare images: (' . $status . ') ' . implode("\n", $output));
        }

        $result = new Result();
        $result->setCommandLine($command_line);

        if (!$status) {
            $result->setImage(new File($output_file))
                ->setExtra(implode(PHP_EOL, $output));
        }

        return $result;
    }
} 