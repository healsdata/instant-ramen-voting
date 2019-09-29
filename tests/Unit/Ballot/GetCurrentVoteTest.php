<?php

namespace Healsdata\InstantRamenVoting\Tests\Unit\Ballot;

use PHPUnit\Framework\TestCase;
use Healsdata\InstantRamenVoting\Ballot;
use Healsdata\InstantRamenVoting\Candidate;

class GetCurrentVoteTest extends TestCase
{
    public function testNoRemainingVotesReturnsExhausted()
    {
        $ballot = new Ballot([]);

        $this->assertCurrentVote($ballot, [], Candidate::EXHAUSTED);
    }

    public function testReturnsFirstCandidateWhenNoneEliminated()
    {
        $candidate1 = new Candidate('The Rock');
        $candidate2 = new Candidate('Sylvanas');

        $ballot = new Ballot([$candidate1, $candidate2]);

        $this->assertCurrentVote($ballot, [], $candidate1->getName());
    }

    public function testReturnsSecondCandidateWhenFirstIsEliminated()
    {
        $candidate1 = new Candidate('The Rock');
        $candidate2 = new Candidate('Sylvanas');

        $ballot = new Ballot([$candidate1, $candidate2]);

        $this->assertCurrentVote($ballot, [$candidate1], $candidate2->getName());
    }

    public function testReturnsFirstCandidateWhenSecondIsEliminated()
    {
        $candidate1 = new Candidate('The Rock');
        $candidate2 = new Candidate('Sylvanas');

        $ballot = new Ballot([$candidate1, $candidate2]);

        $this->assertCurrentVote($ballot, [$candidate2], $candidate1->getName());
    }

    public function testExhaustedWhenAllEliminated()
    {
        $candidate1 = new Candidate('The Rock');
        $candidate2 = new Candidate('Sylvanas');

        $ballot = new Ballot([$candidate1, $candidate2]);

        $this->assertCurrentVote($ballot, [$candidate1, $candidate2], Candidate::EXHAUSTED);
    }

    private function assertCurrentVote(Ballot $ballot, array $eliminatedCandidates, string $expectedCandidateName)
    {
        $this->assertEquals($expectedCandidateName, $ballot->getCurrentVote($eliminatedCandidates)->getName());
    }
}