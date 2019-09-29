<?php

namespace Healsdata\InstantRamenVoting;

use Healsdata\InstantRamenVoting\Calculator\MajorityVoteCalculator;
use Healsdata\InstantRamenVoting\Ballot\IsBallotSpoiledSpecification;

class Election
{
    /** @var Candidate[] */
    private $candidates = [];

    /** @var Ballot[] */
    private $ballots = [];

    public function addCandidate(Candidate $candidate) : void
    {
        $this->candidates[] = $candidate;
    }

    public function addBallot(Ballot $ballot) : void
    {
        $this->ballots[] = $ballot;
    }

    public function getWinner() : Candidate
    {
        $eliminatedCandidates = [];

        $majorityVotesNeeded = (new MajorityVoteCalculator())->calculate(sizeof($this->ballots));

        while (true) {
            $votes = [];

            foreach ($this->ballots as $ballot) {

                if ((new IsBallotSpoiledSpecification())->isSatisfiedBy($ballot)) {
                    continue;
                }

                $vote = $ballot->getCurrentVote($eliminatedCandidates)->getName();

                if ($vote == Candidate::EXHAUSTED) {
                    continue;
                }

                if (!array_key_exists($vote, $votes)) {
                    $votes[$vote] = 0;
                }

                $votes[$vote]++;
            }

            if (empty($votes)) {
                return new Candidate(Candidate::EXHAUSTED);
            
            }

            $minVote = min($votes);

            foreach ($votes as $name => $vote) {

                foreach ($this->candidates as $candidate) {
                    if ($candidate->getName() == $name) {
                        $thisCandidate = $candidate;
                        break;
                    }
                }

                if ($vote >= $majorityVotesNeeded) {
                    return $thisCandidate;
                }

                if ($vote == $minVote) {
                    $eliminatedCandidates[] = $thisCandidate;
                }           

            }
        }
    }
}