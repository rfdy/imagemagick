<?php

namespace Rfd\ImageMagick\Options;

abstract class CommonOptions {
    /**
     * Replaces "Smart Fit"
     */
    const MODE_ONLY_SHRINK_LARGER   = 1;

    const MODE_FILL_AREA   = 2;

    const MODE_FILL_AREA_OR_FIT = 4;

    const MODE_RESIZE_ABSOLUTE = 8;

    // Gravity definitions.  Follows ImageMagick's conventions.

    const GRAVITY_NORTHWEST     = 'northwest';

    const GRAVITY_NORTH         = 'north';

    const GRAVITY_NORTHEAST     = 'northeast';

    const GRAVITY_WEST          = 'west';

    const GRAVITY_CENTER        = 'center';

    const GRAVITY_EAST          = 'east';

    const GRAVITY_SOUTHWEST     = 'southwest';

    const GRAVITY_SOUTH         = 'south';

    const GRAVITY_SOUTHEAST     = 'southeast';

    const FORMAT_JPG            = 'jpg';
    const FORMAT_JEPG           = 'jpg';
    const FORMAT_PNG            = 'png';
    const FORMAT_GIF            = 'gif';

} 