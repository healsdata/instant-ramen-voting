<?php

namespace Healsdata\InstantRamenVoting;

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

        $majorityVotesNeeded = ceil(sizeof($this->ballots) / 2);

        while (true) {
            $votes = [];

            foreach ($this->ballots as $ballot) {

                $candidates = $ballot->getRankedCandidates();
                $candidates = array_values(array_diff($candidates, $eliminatedCandidates));

                if (!sizeof($candidates)) {
                    continue;
                }

                $vote = $candidates[0]->getName();

                if (!array_key_exists($vote, $votes)) {
                    $votes[$vote] = 0;
                }

                $votes[$vote]++;
            }

            if (empty($votes)) {
                return new Candidate('No Winner');
            
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