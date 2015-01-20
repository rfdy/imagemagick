<?php

namespace Rfd\ImageMagick\Operation;

abstract class RemoveProfile extends OneShotOperation implements OneShotHasArgument {

    protected $profile;

    public function removeProfile($profile) {
        $this->profile = $profile;
    }

    /**
     * @param mixed $value
     *
     * @return Builder
     */
    public function setValue($value) {
        $this->removeProfile($value);
    }


}