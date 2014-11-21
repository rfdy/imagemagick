<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Exception\ImageMagickException;
use Rfd\ImageMagick\Image\Image;
use Rfd\ImageMagick\Operation\InstantOperation;
use Rfd\ImageMagick\Operation\Operation;

class Processor implements \Rfd\ImageMagick\Operation\Processor {

    /** @var Operation[] */
    protected $operations = array();

    protected $temp_filenames = array();

    protected $temp_input_filename;

    protected $output_format = 'jpg';
    protected $output_format_is_forced = false;

    public function addOperation(Operation $operation) {
        $operation->setProcessor($this);

        $this->operations[] = $operation;
    }

    public function processOperations(Image $input_image, Image $output_image = null) {
        $command_line = $this->getImageMagickConvert();

        $this->temp_input_filename = $this->getTempFilename('input_');
        file_put_contents($this->temp_input_filename, $input_image->getImageData());

        $command_line .= ' ' . escapeshellarg($this->temp_input_filename) . ' ';

        foreach ($this->operations as $operation) {
            if ($operation instanceof InstantOperation) {
                return $operation->process($input_image, $command_line);
            }

            $command_line = $operation->process($input_image, $command_line)->getCommandLine() . ' ';
        }

        $temp_output_filename = '';

        if ($output_image) {
            $temp_output_filename = $this->getTempFilename('output_');
            $command_line .= $this->getOutputFileWithFormat($temp_output_filename);
        }

        // Remove extra whitespace between operations
        $command_line = preg_replace('/\s+/', ' ', $command_line);

        // Check for a no-op.  Don't lose fidelity by converting it to itself
        // Also check to make sure it hasn't been forced.  We assume that the Convert operation wouldn't set the format if it didn't have to.
        if (!$this->output_format_is_forced && trim($command_line) == $this->getImageMagickConvert() . ' ' . escapeshellarg($this->temp_input_filename) . ' ' . $this->getOutputFileWithFormat($temp_output_filename)) {
            copy($this->temp_input_filename, $temp_output_filename);
            $output = array('No-op; Copied image');
            $status = 0;
        } else {
            exec($command_line, $output, $status);
        }

        if ($status) {
            throw new ImageMagickException('Error executing ImageMagick: ' . $status);
        }

        if ($output_image && $this->temp_input_filename) {
            $output_image->setImageData(file_get_contents($temp_output_filename));
        }

        return implode("\n", $output);
    }

    public function setOutputFormat($format) {
        $this->output_format_is_forced = true;
        $this->output_format = $format;
    }

    public function getImageMagickConvert() {
        return $this->getImageMagickPath() . DIRECTORY_SEPARATOR . 'convert' . ($this->isWindows() ? '.exe' : '');
    }

    public function getImageMagickPath() {
        //if running on windows assume it's in the path
        if ($this->isWindows()) {
            // Windows' version "where" returns all the matches.
            // Pick the one with "image" in the path.  There's a program named "convert" in \Windows\System32 as well.
            exec('where convert', $output);

            foreach ($output as $line) {
                if (stripos($line, 'image') !== false) {
                    return escapeshellarg(pathinfo($line, PATHINFO_DIRNAME));
                }
            }
        } else {
            exec('which convert', $output, $status);
            return $status == 0 ? pathinfo($output[0], PATHINFO_DIRNAME) : false;
        }

        throw new ImageMagickException('ImageMagick could not be found.');
    }

    public function isWindows() {
        return defined('PHP_WINDOWS_VERSION_MAJOR');
    }

    public function getTempFilename($prefix, $suffix = 'tmp') {
        $name = $this->getTempDir() . DIRECTORY_SEPARATOR . uniqid($prefix) . '.' . $suffix;
        $this->temp_filenames[] = $name;

        return $name;
    }

    protected function getTempDir() {
        return sys_get_temp_dir();
    }

    public function __clone() {
        $this->operations = array();
        $this->temp_filenames = array();
    }

    public function __destruct() {
        foreach ($this->temp_filenames as $filename) {
            if (file_exists($filename)) {
                unlink($filename);
            }
        }
    }

    /**
     * @param $temp_output_filename
     *
     * @return string
     */
    protected function getOutputFileWithFormat($temp_output_filename) {
        return $this->output_format . ':' . escapeshellarg($temp_output_filename);
    }
} 