<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;
use Rfd\ImageMagick\Options\CommonOptions;

/**
 * @property Processor $processor
 */
class Resize extends \Rfd\ImageMagick\Operation\Resize {
    public function process(Image $image, $command_line = '') {
        if ($this->mode & CommonOptions::MODE_FILL_AREA_OR_FIT) {
            // Both...so if it's larger, shrink it to fill the area.
            // Otherwise, fit it.

            // What's my current width & height?
            $current_image_filename = $this->processor->getTempFilename('current_');
            $output_filename = $this->processor->getTempFilename('resize_temp_');

            file_put_contents($current_image_filename, $image->getImageData());
            // 0 => width, 1 => height
            $current_image_data = getimagesize($current_image_filename);

            exec($command_line . ' ' . escapeshellarg($output_filename));
            // 0 => width, 1 => height
            $image_data = getimagesize($output_filename);

            // Image is smaller in some dimension.  Follow the "Only shrink larger" directive, just fit instead.
            if ($image_data[0] < $current_image_data[0] || $image_data[1] < $current_image_data[1]) {
                $this->mode = 0;
            } elseif ($this->width == $image_data[0] && $this->height == $image_data[1]) {
                // The image is the exact same size.  Don't lose fidelity by resizing it.
                $result = new Result();
                $result->setCommandLine($command_line);

                return $result;
            } else {
                $this->mode = CommonOptions::MODE_FILL_AREA;
            }
        }

        if ($this->mode & CommonOptions::MODE_ONLY_SHRINK_LARGER) {
            $command_line .= ' -gravity ' . escapeshellarg($this->gravity);
            $command_line .= ' -thumbnail ' . escapeshellarg($this->width . 'x' . $this->height . '>');
        } elseif ($this->mode & CommonOptions::MODE_FILL_AREA) {
            $command_line .= ' -gravity ' . escapeshellarg($this->gravity);
            $command_line .= ' -thumbnail ' . escapeshellarg($this->width . 'x' . $this->height . '^');
        } elseif ($this->mode & CommonOptions::MODE_RESIZE_ABSOLUTE) {
            $command_line .= ' -gravity ' . escapeshellarg($this->gravity);
            $command_line .= ' -thumbnail ' . escapeshellarg($this->width . 'x' . $this->height . '!');
        } else {
            $command_line .= ' -gravity ' . escapeshellarg($this->gravity);
            $command_line .= ' -thumbnail ' . escapeshellarg($this->width . 'x' . $this->height);
        }

        $result = new Result();
        $result->setCommandLine($command_line);

        return $result;
    }
} 