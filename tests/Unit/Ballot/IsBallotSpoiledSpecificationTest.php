<?php

namespace Healsdata\InstantRamenVoting\Tests\Unit\Ballot;

use PHPUnit\Framework\TestCase;
use Healsdata\InstantRamenVoting\Candidate;
use Healsdata\InstantRamenVoting\Ballot;
use Healsdata\InstantRamenVoting\Ballot\IsBallotSpoiledSpecification;

class IsBallotSpoiledSpecificationTest extends TestCase
{
    /** @var IsBallotSpoiledSpecification */
    private $specification;

    public function setUp() : void
    {
        $this->specification = new IsBallotSpoiledSpecification();
    }


    public function testBallotWithDuplicateVotesIsSpoiled()
    {
        $candidate = new Candidate('Doppleganger');

        $ballot = new Ballot([$candidate, $candidate]);

        $this->assertTrue($this->specification->isSatisfiedBy($ballot));
    }

    public function testBallotWithNoVotesIsOK()
    {
        $ballot = new Ballot([]);

        $this->assertFalse($this->specification->isSatisfiedBy($ballot));
    }

    public function testBallotWithRankedVotesIsOK()
    {
        $candidate1 = new Candidate('Billy');
        $candidate2 = new Candidate('Jean');

        $ballot = new Ballot([$candidate1, $candidate2]);

        $this->assertFalse($this->specification->isSatisfiedBy($ballot));
    }    
}