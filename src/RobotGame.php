<?php

class RobotGame
{

    private $invalidCorners = []; // cache invalid corners
    private $maxX;
    private $maxY;

    /**
     * RobotGame constructor.
     * @param $maxX
     * @param $maxY
     */
    public function __construct($maxX, $maxY)
    {
        $this->maxX = $maxX;
        $this->maxY = $maxY;
    }


    /**
     * Check if quadrant is invalid
     * @param $x
     * @param $y
     * @return bool
     */
    public function shouldIgnore($x, $y)
    {

        return (isset($this->invalidCorners[sprintf("%s-%s", $x, $y)])) ? true : false;

    }

    /**
     * Cache invalid quadrants
     * @param $x
     * @param $y
     */
    private function setInvalid($x, $y)
    {
        $this->invalidCorners[sprintf("%s-%s", $x, $y)] = true;
    }

    /**
     * Interpret move commands for robot
     * Extend if different moves are available
     * @param Robot $robot
     * @param $command
     */
    public function moveRobot(Robot $robot, $command)
    {
        $commands = str_split($command, 1);
        while (sizeof($commands) > 0 && !$robot->isLost()) {
            $step = array_shift($commands);
            switch ($step) {
                case 'F':
                    $this->moveForward($robot);
                    break;
                case 'L':
                    $this->turnLeft($robot);
                    break;
                case 'R':
                    $this->turnRight($robot);
                    break;
                default:
                    throw new \Exception(sprintf('Unknown command %s',$step),1);
            }
        }
    }

    /**
     * Moves forward a robot based on current direction
     * TODO: Extend with different directions, i.e. diagonal
     *
     * @param Robot $robot
     */
    private function moveForward(Robot $robot)
    {

        [$x, $y] = $robot->getPos();
        $orientation = $robot->getOrientation();

        switch ($orientation) {
            case 'N':
                $y++;
                break;
            case 'W':
                $x--;
                break;
            case 'S':
                $y--;
                break;
            case 'E':
                $x++;
                break;
        }

        if ($this->shouldIgnore($x, $y)) {
            return;
        }

        if (!$this->isOnMars($x, $y)) {
            $this->setInvalid($x, $y);
            $robot->setLost();
            return;
        }

        $robot->setX($x);
        $robot->setY($y);
    }

    /**
     * Find if robot is on mars on given coordinates
     * extend if mars is differently shaped
     * @param $x
     * @param $y
     * @return bool
     */
    private function isOnMars($x, $y)
    {
        return ($x >= 0 && $y >= 0 && $x <= $this->maxX && $y <= $this->maxY);
    }

    /**
     * @param Robot $robot
     */
    private function turnLeft(Robot $robot)
    {
        $currentOrientation = $robot->getOrientation();
        switch ($currentOrientation) {
            case 'N':
                $robot->setOrientation('W');
                break;
            case 'W':
                $robot->setOrientation('S');
                break;
            case 'S':
                $robot->setOrientation('E');
                break;
            case 'E':
                $robot->setOrientation('N');
                break;
        }
    }

    /**
     * @param Robot $robot
     */
    private function turnRight(Robot $robot)
    {
        $currentOrientation = $robot->getOrientation();
        switch ($currentOrientation) {
            case 'N':
                $robot->setOrientation('E');
                break;
            case 'W':
                $robot->setOrientation('N');
                break;
            case 'S':
                $robot->setOrientation('W');
                break;
            case 'E':
                $robot->setOrientation('S');
                break;
        }
    }

}

