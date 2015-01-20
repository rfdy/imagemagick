<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;

/**
 * @property Processor $processor
 */
class Info extends \Rfd\ImageMagick\Operation\Info {

    public function process(Image $image, $command_line = '') {
        $status = 0;
        $output = array();

        $temp_file = $this->processor->getTempFilename('info_');
        file_put_contents($temp_file, $image->getImageData());

        exec($this->processor->getImageMagickConvert() . ' -density 120 ' . escapeshellarg($temp_file) . ' -format "%w,%h,%z,%m,%Q" info:', $output, $status);

        $result = new Result();
        $result->setCommandLine($command_line);

        if (!$status) {
            $size_arr = explode(',', $output[0]);
            $result->setExtra(array(
                'width' => $size_arr[0],
                'height' => $size_arr[1],
                'depth' => $size_arr[2],
                'type' => $size_arr[3],
                'quality' => $size_arr[4]
            ));
        }

        return $result;
    }
} 