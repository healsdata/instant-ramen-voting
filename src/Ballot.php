<?php

namespace Healsdata\InstantRamenVoting;

use Healsdata\InstantRamenVoting\Candidate;

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

    public function getCurrentVote(array $eliminatedCandidates) : Candidate
    {
        $remainingCandidates = array_values(array_diff($this->getRankedCandidates(), $eliminatedCandidates));

        if (!sizeof($remainingCandidates)) {
            return new Candidate(Candidate::EXHAUSTED);
        }

        return $remainingCandidates[0];
    }
}