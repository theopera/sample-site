<?php

namespace Opera\SampleSite;


use Opera\Component\WebApplication\Controller;

class MyController extends Controller
{
    /**
     * @var MyContainer
     */
    private $container;

    protected function getContainer() : MyContainer
    {
        if ($this->container === null) {
            $this->container = new MyContainer($this->getContext());
        }

        return $this->container;
    }

}