<?php

namespace Healsdata\InstantRamenVoting\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Healsdata\InstantRamenVoting\Calculator\MajorityVoteCalculator;
use SebastianBergmann\Diff\InvalidArgumentException;

class MajorityVoteCalculatorTest extends TestCase
{
    /**
     * @dataProvider dataProviderBallotCountSamples
     * @param int $numBallots
     * @param int $expectedMajorityVote
     * @return void
     */
    public function testMajorityVoteSamples(int $numBallots, int $expectedMajorityVote) : void
    {
        $this->assertEquals($expectedMajorityVote, (new MajorityVoteCalculator())->calculate($numBallots));
    }

    public function dataProviderBallotCountSamples()
    {
        return [
            [1, 1],
            [2, 2],
            [3, 2],
            [4, 3],
            [5, 3],
            [100, 51],
            [123456, 61729],
            [123457, 61729],
        ];
    }
    
    public function testMajorityVoteZeroBallots() : void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new MajorityVoteCalculator())->calculate(0);
    }

    public function testMajorityVotesNegativeBallots() : void
    {
        $this->expectException(\InvalidArgumentException::class);

        (new MajorityVoteCalculator())->calculate(-1);
    }

}