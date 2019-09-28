<?php

namespace Healsdata\InstantRamenVoting;

class Ballot
{
    /** @var Candidate[]|array */
    private $rankedCandidates;

    public function __construct(array $rankedCandidates)
    {
        $this->rankedCandidates = $rankedCandidates;
    }

    /**
     * @return Candidate[]|array
     */
    public function getRankedCandidates() : array
    {
        return $this->rankedCandidates;
    }
}