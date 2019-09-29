<?php

namespace Healsdata\InstantRamenVoting\Ballot;

use Healsdata\InstantRamenVoting\Ballot;

class IsBallotSpoiledSpecification 
{
    public function isSatisfiedBy(Ballot $ballot) : bool
    {
        return sizeof($ballot->getRankedCandidates()) != sizeof(array_unique($ballot->getRankedCandidates(), SORT_STRING));
    }
}