<?php

spl_autoload_register(function ($class) {
    include __DIR__ . '/../src/' . $class . '.php';
});

use PHPUnit\Framework\TestCase;

class RobotTest extends TestCase
{
    public function testInstantiateNewRobot(): void
    {
        $robot = new Robot([1,1,'N']);
        $this->assertInstanceOf(Robot::class, $robot);
        $this->assertTrue(trim($robot->printResult()) == "1 1 N");
    }

    public function testRobotSetLost() : void {
        $robot = new Robot([1,1,'N']);
        $robot->setLost();
        $this->assertTrue(trim($robot->printResult()) == "1 1 N LOST");
        $this->assertTrue($robot->isLost());
    }

    public function testRobotGetPos() : void {
        $robot = new Robot([1,1,'N']);
        $this->assertEquals([1,1],$robot->getPos());
    }

    public function testRobotSetX() : void {
        $robot = new Robot([1,1,'N']);
        $this->assertEquals([1,1],$robot->getPos());
        $robot->setX(11);
        $this->assertEquals([11,1],$robot->getPos());
    }

    public function testRobotSetY() : void {
        $robot = new Robot([1,1,'N']);
        $this->assertEquals([1,1],$robot->getPos());
        $robot->setY(11);
        $this->assertEquals([1,11],$robot->getPos());
    }

    public function testRobotGetOrientation() : void {
        $robot = new Robot([1,1,'N']);
        $this->assertEquals('N',$robot->getOrientation());
    }

}
