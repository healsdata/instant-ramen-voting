<?php 

namespace Healsdata\InstantRamenVoting\Tests\Acceptance;

use PHPUnit\Framework\TestCase;
use Healsdata\InstantRamenVoting\Election;
use Healsdata\InstantRamenVoting\Candidate;
use Healsdata\InstantRamenVoting\Ballot;

class WikipediaExamplesTest extends TestCase
{

    public function testFiveVotersThreeCandidates()
    {
        $election = new Election();

        $bob = new Candidate('Bob');
        $sue = new Candidate('Sue');
        $bill = new Candidate('Bill');

        $election->addCandidate($bob);
        $election->addCandidate($sue);
        $election->addCandidate($bill);

        $election->addBallot(new Ballot([$bob, $bill, $sue]));
        $election->addBallot(new Ballot([$sue, $bob, $bill]));
        $election->addBallot(new Ballot([$bill, $sue, $bob]));
        $election->addBallot(new Ballot([$bob, $bill, $sue]));
        $election->addBallot(new Ballot([$sue, $bob, $bill]));

        $this->assertEquals($sue, $election->getWinner());
    }

    public function testTennesseeCapitalElection()
    {
        $election = new Election();

        $memphis = new Candidate('Memphis');
        $nashville = new Candidate('Nashville');
        $knoxville = new Candidate('Knoxville');
        $chattanooga = new Candidate('Chattanooga');

        $election->addCandidate($memphis);
        $election->addCandidate($nashville);
        $election->addCandidate($knoxville);
        $election->addCandidate($chattanooga);

        for ($i = 1; $i <= 42; $i++) {
            $election->addBallot(new Ballot([$memphis, $nashville, $chattanooga, $knoxville]));
        }

        for ($i = 1; $i <= 26; $i++) {
            $election->addBallot(new Ballot([$nashville, $chattanooga, $knoxville, $memphis]));
        }     
        
        for ($i = 1; $i <= 15; $i++) {
            $election->addBallot(new Ballot([$chattanooga, $knoxville, $nashville, $memphis]));
        }       

        for ($i = 1; $i <= 17; $i++) {
            $election->addBallot(new Ballot([$knoxville, $chattanooga, $nashville, $memphis]));
        }              

        $this->assertEquals($knoxville, $election->getWinner());
    }    
}
