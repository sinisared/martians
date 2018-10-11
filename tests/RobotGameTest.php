<?php

spl_autoload_register(function ($class) {
    include __DIR__ . '/../src/' . $class . '.php';
});

use PHPUnit\Framework\TestCase;

class RobotGameTest extends TestCase
{
    public function testInstantiateNewGame(): void
    {
        $robotGame = new RobotGame(1, 1);
        $this->assertInstanceOf(RobotGame::class, $robotGame);
    }

    public function testRobotTurnRight(): void
    {
        $robotGame = new RobotGame(2, 2);
        $robot = new Robot([0,0,'N']);
        $this->assertEquals('N', $robot->getOrientation());
        $robotGame->moveRobot($robot, 'R');
        $this->assertEquals('E', $robot->getOrientation());
        $robotGame->moveRobot($robot, 'R');
        $this->assertEquals('S', $robot->getOrientation());
        $robotGame->moveRobot($robot, 'R');
        $this->assertEquals('W', $robot->getOrientation());
    }

    public function testRobotTurnLeft(): void
    {
        $robotGame = new RobotGame(2, 2);
        $robot = new Robot([0,0,'N']);
        $this->assertEquals('N', $robot->getOrientation());
        $robotGame->moveRobot($robot, 'L');
        $this->assertEquals('W', $robot->getOrientation());
        $robotGame->moveRobot($robot, 'L');
        $this->assertEquals('S', $robot->getOrientation());
        $robotGame->moveRobot($robot, 'L');
        $this->assertEquals('E', $robot->getOrientation());
    }

    public function testRobotMoveForward(): void
    {
        $robotGame = new RobotGame(2, 2);
        $robot = new Robot([0,0,'N']);
        $this->assertEquals('N', $robot->getOrientation());
        $this->assertEquals([0,0], $robot->getPos());
        $robotGame->moveRobot($robot, 'F');
        $this->assertEquals('N', $robot->getOrientation());
        $this->assertEquals([0,1], $robot->getPos());
        $robotGame->moveRobot($robot, 'F');
        $this->assertEquals('N', $robot->getOrientation());
        $this->assertEquals([0,2], $robot->getPos());
        $robotGame->moveRobot($robot, 'F');
        // must fail
        $this->assertEquals('N', $robot->getOrientation());
        $this->assertEquals([0,2], $robot->getPos());
        $this->assertTrue($robot->isLost());
    }

    public function testRobotMoveForwardNorthSingleCommand(): void
    {
        $robotGame = new RobotGame(2, 4);
        $robot = new Robot([0,0,'N']);
        $this->assertEquals('N', $robot->getOrientation());
        $this->assertEquals([0,0], $robot->getPos());
        $robotGame->moveRobot($robot, 'FFFFFFFF');
        $this->assertEquals('N', $robot->getOrientation());
        $this->assertEquals([0,4], $robot->getPos());
        $this->assertTrue($robot->isLost());
    }

    public function testRobotMoveForwardEastSingleCommand(): void
    {
        $robotGame = new RobotGame(4, 4);
        $robot = new Robot([0,0,'E']);
        $this->assertEquals('E', $robot->getOrientation());
        $this->assertEquals([0,0], $robot->getPos());
        $robotGame->moveRobot($robot, 'FFFFFFFF');
        $this->assertEquals('E', $robot->getOrientation());
        $this->assertEquals([4,0], $robot->getPos());
        $this->assertTrue($robot->isLost());
    }


    public function testSecondRobotMoveForwardEastSingleCommand(): void
    {
        $robotGame = new RobotGame(4, 4);
        $robot = new Robot([0,0,'E']);
        $robot2 = new Robot([0,0,'E']);
        $this->assertEquals('E', $robot->getOrientation());
        $this->assertEquals([0,0], $robot->getPos());
        // first dies
        $robotGame->moveRobot($robot, 'FFFFFFFF');
        $this->assertEquals('E', $robot->getOrientation());
        $this->assertEquals([4,0], $robot->getPos());
        $this->assertTrue($robot->isLost());
        $this->assertEquals('E', $robot2->getOrientation());
        $this->assertEquals([0,0], $robot2->getPos());
        //second should be saved
        $robotGame->moveRobot($robot2, 'FFFFFFFF');
        $this->assertEquals('E', $robot2->getOrientation());
        $this->assertEquals([4,0], $robot2->getPos());
        $this->assertTrue(!$robot2->isLost());
    }

    public function testSecondRobotMoveForwardNorthSingleCommand(): void
    {
        $robotGame = new RobotGame(4, 4);
        $robot = new Robot([0,0,'N']);
        $robot2 = new Robot([0,0,'N']);
        $this->assertEquals('N', $robot->getOrientation());
        $this->assertEquals([0,0], $robot->getPos());
        $robotGame->moveRobot($robot, 'FFFFFFFF');
        $this->assertEquals('N', $robot->getOrientation());
        $this->assertEquals([0,4], $robot->getPos());
        $this->assertTrue($robot->isLost());
        $this->assertEquals('N', $robot2->getOrientation());
        $this->assertEquals([0,0], $robot2->getPos());
        // second should be saved
        $robotGame->moveRobot($robot2, 'FFFFFFFF');
        $this->assertEquals('N', $robot2->getOrientation());
        $this->assertEquals([0,4], $robot2->getPos());
        $this->assertTrue(!$robot2->isLost());
    }

    public function testThirdRobotMoveForwardNorthTurnEastTurnNorthForwardGetLostSingleCommand(): void
    {
        $robotGame = new RobotGame(4, 4);
        $robot = new Robot([0,0,'N']);
        $robot2 = new Robot([0,0,'N']);
        $robot3 = new Robot([0,0,'N']);
        $this->assertEquals('N', $robot->getOrientation());
        $this->assertEquals([0,0], $robot->getPos());
        $robotGame->moveRobot($robot, 'FFFFFFFF');
        $this->assertEquals('N', $robot->getOrientation());
        $this->assertEquals([0,4], $robot->getPos());
        $this->assertTrue($robot->isLost());
        $this->assertEquals('N', $robot2->getOrientation());
        $this->assertEquals([0,0], $robot2->getPos());
        // second should be saved
        $robotGame->moveRobot($robot2, 'FFFFFFFF');
        $this->assertEquals('N', $robot2->getOrientation());
        $this->assertEquals([0,4], $robot2->getPos());
        $this->assertTrue(!$robot2->isLost());
        // third should be saved moved one east
        $robotGame->moveRobot($robot3, 'FFFFFRF');
        $this->assertEquals('E', $robot3->getOrientation());
        $this->assertEquals([1,4], $robot3->getPos());
        $this->assertTrue(!$robot3->isLost());
        // third gets lost
        $robotGame->moveRobot($robot3, 'LF');
        $this->assertEquals('N', $robot3->getOrientation());
        $this->assertEquals([1,4], $robot3->getPos());
        $this->assertTrue($robot3->isLost());
    }


}
