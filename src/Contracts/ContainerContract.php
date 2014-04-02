<?php namespace Slocator\Contracts;

interface ContainerContract {

    /**
     * Resolve a given abstract type from the container
     *
     * @param  string $abstract
     * @return mixed
     */
    public function make($abstract);

}

