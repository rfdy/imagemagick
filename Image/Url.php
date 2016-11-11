<?php

namespace Rfd\ImageMagick\Image;

use Rfd\ImageMagick\Exception\ImageMagickException;

class Url implements Image
{

    protected $curlOptions = [];

    protected $url;

    protected $imageData = null;

    public function __construct($url, $curlOptions = [])
    {
        $this->url = $url;
        $this->curlOptions = $curlOptions;
    }

    /**
     * Returns the complete image data, wherever it may have come from.
     *
     * @return string
     */
    public function getImageData()
    {
        if ($this->imageData === null) {
            $this->imageData = $this->download($this->url);
        }
        return $this->imageData;
    }

    /**
     * @param string $imageData
     *
     * @throws ImageMagickException
     */
    public function setImageData($imageData)
    {
        throw new ImageMagickException('Url image does not support output');
    }

    protected function download($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        foreach ($this->curlOptions as $curlOption => $value) {
            curl_setopt($ch, $curlOption, $value);
        }

        $data = curl_exec($ch);
        if ($data === false) {
            throw new ImageMagickException('Url image failed CURL ' . curl_error($ch));
        }
        return $data;
    }

}
