<?php

namespace Rfd\ImageMagick\Image;

use Rfd\ImageMagick\Exception\ImageMagickException;

class Url implements Image {

    protected $timeout = 5;
    
    protected $url;

    protected $image_type;

    public function __construct($url, $timeout = 5) {
        $this->url = $url;
        $this->timeout = $timeout;
    }

    /**
     * Returns the complete image data, wherever it may have come from.
     *
     * @return string
     */
    public function getImageData() {
        return $this->download($this->url);
    }

    /**
     * @param string $image_data
     *
     * @return void
     */
    public function setImageData($image_data) {
        throw new ImageMagickException('Url image does not support output');
    }
    
    protected function download($url)
    {
        $ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
    	$data = curl_exec($ch);
    	if($data === false)
        {
            throw new ImageMagickException('Url image failed CURL ' . curl_error($ch));
        }
    	return $data;
    }

}
