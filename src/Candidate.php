<?php

namespace Healsdata\InstantRamenVoting;

class Candidate
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function __toString() : string
    {
        return $this->getName();
    }
}