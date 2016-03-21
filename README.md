imagemagick
===========

RFD ImageMagick library.

# Requirements
- ImageMagick must be in your $PATH (e.g. /usr/bin/convert)
- PHP must be able to run `exec()`

# Usage

`composer require rfd/imagemagick`

```php
<?php

use Rfd\ImageMagick\ImageMagick;
use Rfd\ImageMagick\CLI\Operation\Factory as OperationFactory;
use Rfd\ImageMagick\Image\File;
use Rfd\ImageMagick\Options\CommonOptions;

require __DIR__ . '/vendor/autoload.php';

$im = new ImageMagick(new OperationFactory());

$image = new File('/path/to/your/image.png');
$output = new File('/path/to/output/image.jpg');

$operation_builder = $im->getOperationBuilder($image);

$operation_builder
    ->resize()
        ->setWidth(320)
        ->setHeight(240)
        ->setGravity(CommonOptions::GRAVITY_CENTER)
    ->next()
    ->slice()
        ->setWidth(300)
        ->setHeight(200)
        ->setOffsetX(0)
        ->setOffsetY(0)
        ->setGravity(CommonOptions::GRAVITY_NORTHWEST)
    ->finish($output);

```

# About
## Included Functionality
Included is only a few commands that we've found useful at RedFlagDeals.  You're able to string them together to get most common things done.

### Commands
#### Slice
Extracts a rectangle from the image based on the width, height, offset X, offset Y, and gravity.
#### Resize
Resizes the image based on the width, height, gravity and resize mode
##### Modes
`CommonOptions::MODE_ONLY_SHRINK_LARGER` Will only shrink the image if it is larger than the requested dimensions.  Otherwise it leaves the image alone.  See: http://www.imagemagick.org/Usage/resize/#shrink

`CommonOptions::MODE_FILL_AREA` will resize to the smallest dimension.  See: http://www.imagemagick.org/Usage/resize/#fill

`CommonOptions::MODE_FILL_AREA_OR_FIT` will shrink to fill the area if the image is larger than the requested width and height.  Otherwise it will increase the image's size to fit within the width and height.

`CommonOptions::MODE_RESIZE_ABSOLUTE` doesn't care about the aspect ratio and forces the image to be exactly the requested width and height.  See: http://www.imagemagick.org/Usage/resize/#noaspect

#### Convert
Some defaults are set at `CommonOptions::FORMAT_*` it will force the output mode to a specific image type.  Any string that ImageMagick recognizes as an image format will be accepted.

#### Watermark
Could also be called "Composite."  This takes one image, resizes it to 98% the size of another image, and slaps it on top.  If you use an image with transparency (like we do) you get a nice watermark.

#### Info
Returns an array of image information from `Result->getExtra()`.  This is an "Instant" operation.  Nothing after it will be processed.

#### Compare
Returns a float value or "inf" on `Result->getExtra()` and an image with the compare result on `Result->getImage()`.  This is an "Instant" operation.  Nothing after it will be processed.

#### Blur / Gaussian Blur
Blurs the image by radius and sigma.  Blur is faster, Gaussian Blur is smoother.  See: http://www.imagemagick.org/Usage/blur/

#### Quality
Sets the output quality of the image.  Generally only useful with lossy formats like JPEG.  With PNG, it determines the compression.  See: http://www.imagemagick.org/script/command-line-options.php#quality  

#### Strip
Removes profile information from the image.  See: http://www.imagemagick.org/script/command-line-options.php#strip

#### Add Profile, Remove Profile
Adds or removes profile information to the image.  AddProfile expects a file name.  RemoveProfile expects a profile name.  See: http://www.imagemagick.org/script/command-line-options.php#profile 
```
$operation_builder->addProfile('RGB.icc')
    ->removeProfile('!exif,*')
```
Be careful, though.  Each usage of these methods causes the image to be converted in memory from one profile to another.  Read the doc carefully! 

## Processing Images
All processing is done after the command has been built by calling `Builder->finish()`.  If a subclass of Image is provided, it will call `Image->setImageData()` on it.
## Instant Operations
Currently there are two "instant" operations, Info and Compare.  Due to the nature of the information returned, it doesn't make sense to continue processing.
## One-Shot Operations
One-Shot operations can take parameters when the operation is requested, instead of having to use ->next().

```
// These two are exactly the same:

$operation_builder->format(CommonOptions::FORMAT_JPG)
    ->...;

$operation_builder->format()
    ->setFormat(CommonOptions::FORMAT_JPG)
    ->next()
    ->...;
```

Quality, Format, AddProfile, RemoveProfile, and Strip can be called this way.

```
// Strip is called without parameters
$operation_builder->strip()->...;
```


## Notes
#### Only works on the command line
We've never used the IMagick PECL extension.  The implementation provided is completely CLI-based.  The command line is built, then run when `Builder->finish()` is called.

#### ImageMagick Version
This library was built against ImageMagick 6.7.7-10 Q16 on Linux.  The PHPUnit tests MAY fail when comparing images in different versions.  Improvements to the tests to help with this would be greatly appreciated.

#### Windows Compatibility
It should be windows-compatible, we've done a small amount of testing on Windows and there are little fixes for it in the code.  However, there is no guarantee that it will work flawlessly on Windows.

# Contributing
Pull requests are welcome and encouraged!  We know there's a lot that hasn't been implemented yet.
