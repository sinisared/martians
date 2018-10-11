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

}

