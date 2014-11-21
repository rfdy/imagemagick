<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Exception\ImageMagickException;
use Rfd\ImageMagick\Image\Image;


/**
 * @property Processor $processor
 */
class Watermark extends \Rfd\ImageMagick\Operation\Watermark {
    const MAX_WATERMARK_WIDTH = 250;
    const MAX_WATERMARK_HEIGHT = 250;

    public function process(Image $image, $command_line = '') {
        if (!$this->watermark_image) {
            throw new ImageMagickException('Can\'t watermark if there\'s no image to watermark with!');
        }

        $pre_watermark_filename = $this->processor->getTempFilename('pre_watermark_');
        $watermark_filename = $this->processor->getTempFilename('watermark_');

        // Run the current queue to see how big the resultant image is.
        exec($command_line . ' ' . escapeshellarg($pre_watermark_filename));

        file_put_contents($watermark_filename, $this->watermark_image->getImageData());

        // 0 => width, 1 => height
        $image_data = getimagesize($pre_watermark_filename);

        // Fit the watermark to 0.98 * the size of the image, assuming the image is big enough.
        $scale = 0.98;
        $maxsize = min($image_data[0], $image_data[1]);
        $width = intval($maxsize * $scale);

        // Only watermark if it's bigger than a certain size.
        if ($image_data[0] >= self::MAX_WATERMARK_WIDTH || $image_data[1] >= self::MAX_WATERMARK_HEIGHT) {
            if ($this->processor->isWindows()) {
                $command_line .= ' -gravity center ( ' . escapeshellarg($watermark_filename) . ' -resize ' . $width . 'x' . $width . ' ) -composite ';
            } else {
                $command_line .= ' -gravity center \\( ' . escapeshellarg($watermark_filename) . ' -resize ' . $width . 'x' . $width . ' \\) -composite ';
            }
        }

        $result = new Result();
        $result->setCommandLine($command_line);

        return $result;
    }



} 