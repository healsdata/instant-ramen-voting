<?php

namespace Healsdata\InstantRamenVoting\Calculator;

use InvalidArgumentException;

class MajorityVoteCalculator
{

    /**
     * @throws InvalidArgumentException
     * @param int $numBallots
     * @return int
     */
    public function calculate(int $numBallots) : int
    {
        if ($numBallots < 1) {
            throw new InvalidArgumentException("The number of ballots must be a positive integer. Found {$numBallots}.");
        }
        
        return floor($numBallots / 2) + 1;
    }

}