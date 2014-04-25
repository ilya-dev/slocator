<?php namespace Slocator\Contracts;

interface ContainerContract {

    /**
     * Resolve an abstract type out of the container.
     *
     * @param string $abstract
     * @return mixed
     */
    public function make($abstract);

}

