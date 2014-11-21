<?php

namespace Rfd\ImageMagick\Operation;

interface Factory {
    /**
     * @param string $operation_name An Operation::* constant
     * @param array  $arguments
     *
     * @return Operation
     */
    public function getOperation($operation_name, $arguments = array());

    /**
     * @return Processor
     */
    public function getProcessor();

    /**
     * @return Processor
     */
    public function getNewProcessor();
} 