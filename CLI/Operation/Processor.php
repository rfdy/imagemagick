<?php

namespace Rfd\ImageMagick\CLI\Operation;

use Rfd\ImageMagick\Exception\ImageMagickException;
use Rfd\ImageMagick\Image\Image;
use Rfd\ImageMagick\Operation\Density;
use Rfd\ImageMagick\Operation\SequenceNumber;
use Rfd\ImageMagick\Operation\InstantOperation;
use Rfd\ImageMagick\Operation\Operation;

class Processor implements \Rfd\ImageMagick\Operation\Processor {

    const QUIRK_RESULT_IS_ONE_WHEN_COMPARE_FAILS = 1;


    /** @var Operation[] */
    protected $operations = array();

    protected $temp_filenames = array();

    protected $temp_input_filename;

    protected $output_format;
    protected $output_format_is_forced = false;

    protected $quirks;

    /** @var string */
    protected $imagemagick_binary_name = 'convert';

    public function addOperation(Operation $operation) {
        $operation->setProcessor($this);

        $this->operations[] = $operation;
    }

    public function processOperations(Image $input_image, Image $output_image = null) {
        $command_line = $this->getImageMagickConvert();

        $this->temp_input_filename = $this->getTempFilename('input_');
        file_put_contents($this->temp_input_filename, $input_image->getImageData());

        // Check for a SequenceNumber or Density operation.  They're a little special.
        foreach ($this->operations as $index => $operation) {
            if ($operation instanceof SequenceNumber) {
                $frame = (int)$operation->getValue();
                if (!$frame) {
                    throw new ImageMagickException('Frame was not an integer');
                }

                $this->temp_input_filename .= '[' . $frame . ']';
                unset($this->operations[$index]);
            }

            if ($operation instanceof Density) {
                $density = (int)$operation->getValue();
                if (!$density) {
                    throw new ImageMagickException('Density was not an integer');
                }

                $command_line .= ' -density ' . $density;
                unset($this->operations[$index]);
            }
        }

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
        return $this->getImageMagickPath() . DIRECTORY_SEPARATOR . $this->imagemagick_binary_name . ($this->isWindows() ? '.exe' : '');
    }

    public function getImageMagickPath() {
        $output = array();
        $status = 0;
        
        //if running on windows assume it's in the path
        if ($this->isWindows()) {
            // Windows' version "where" returns all the matches.
            // Pick the one with "image" in the path.  There's a program named "convert" in \Windows\System32 as well.
            exec('where ' . escapeshellarg($this->imagemagick_binary_name), $output);

            foreach ($output as $line) {
                if (stripos($line, 'image') !== false) {
                    return escapeshellarg(pathinfo($line, PATHINFO_DIRNAME));
                }
            }
        } else {
            exec('which ' . escapeshellarg($this->imagemagick_binary_name), $output, $status);
            if ($status == 0) {
                return pathinfo($output[0], PATHINFO_DIRNAME);
            }
        }

        throw new ImageMagickException('ImageMagick could not be found.');
    }

    public function isWindows() {
        return defined('PHP_WINDOWS_VERSION_MAJOR');
    }

    public function hasImageMagickQuirk($quirk) {
        $this->loadQuirks();

        return $this->quirks & $quirk;
    }

    public function getImageMagickVersion() {
        static $version = null;

        if (!$version && $this->isWindows()) {
            // IM stores this in the registry if you use the installer.
            if (class_exists('COM', false)) {
                $shell = new \COM('WScript.Shell');
                if ($shell) {
                    $version = $shell->RegRead('HKEY_LOCAL_MACHINE\SOFTWARE\ImageMagick\Current\Version');
                }
            }
        }

        if (!$version) {
            // Old-fashioned way.
            exec($this->getImageMagickConvert() . ' -version', $output, $status);
            if ($status) {
                throw new ImageMagickException('ImageMagick was not found.');
            }
            $first_line = $output[0];

            preg_match('/Version: ImageMagick (\d+\.\d+\.\d+)/', $first_line, $matches);
            $version = $matches[1];
        }

        return $version;
    }

    protected function loadQuirks() {
        if (is_null($this->quirks)) {
            $im_version = $this->getImageMagickVersion();

            if (version_compare($im_version, '6.8.1', '>=')) {
                $this->quirks |= self::QUIRK_RESULT_IS_ONE_WHEN_COMPARE_FAILS;
            }
        }
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
        if ($this->output_format) {
            return $this->output_format . ':' . escapeshellarg($temp_output_filename);
        }

        return escapeshellarg($temp_output_filename);
    }

    public function setImageMagickBinaryName($imagemagick_binary_name) {
        $this->imagemagick_binary_name = $imagemagick_binary_name;
    }
} 
