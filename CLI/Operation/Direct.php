<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Image\Image;
use Rfd\ImageMagick\Exception\ImageMagickException;

class Direct extends \Rfd\ImageMagick\Operation\Direct
{
    /**
     * @param Image $image
     * @param string $command_line
     * @return Result
     * @throws ImageMagickException
     */
    public function process(Image $image = null, $command_line = '')
    {
        if (!$this->riskAcknowledged) {
            throw new ImageMagickException('You have not acknowledged the risk of running this command. Call function takeRisk() to use this operation.');
        }

        $result = new Result();

        $result->setCommandLine($command_line . ' ' . $this->command);

        return $result;
    }


}