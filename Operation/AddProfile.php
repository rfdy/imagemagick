<?php

namespace Rfd\ImageMagick\Operation;

abstract class AddProfile extends OneShotOperation implements OneShotHasArgument {

    /** @var string */
    protected $profile;

    /**
     * @param string $profile
     * @return $this
     */
    public function addProfile($profile) {
        $this->profile = $profile;
    }

    /**
     * @param mixed $value
     *
     * @return Builder
     */
    public function setValue($value) {
        $this->addProfile($value);
    }


}