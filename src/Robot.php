<?php
/**
 * Class Robot
 */

class Robot
{
    private $positionX;
    private $positionY;
    private $orientation;
    private $lost = false;

    /**
     * Robot constructor.
     * @param array $initData
     */
    public function __construct($initData = [])
    {
        $this->setX($initData[0]);
        $this->setY($initData[1]);
        $this->setOrientation($initData[2]);
    }

    /**
     * @param $orientation
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;
    }

    /**
     * @return string
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * @param $lost boolean
     */
    public function setLost()
    {
        $this->lost = true;
    }

    /**
     * @return bool
     */
    public function isLost()
    {
        return $this->lost;
    }

    /**
     * @param $x integer
     */
    public function setX($x)
    {
        $this->positionX = $x;
    }

    /**
     * @param $y integer
     */
    public function setY($y)
    {
        $this->positionY = $y;
    }

    /**
     * @return array integer
     */
    public function getPos()
    {
        return [$this->positionX, $this->positionY];
    }
    /**
     * @return string
     */
    public function printResult() {
        return sprintf(
            "%s %s %s %s\n",
            $this->positionX,
            $this->positionY,
            $this->orientation,
            ($this->isLost() ? 'LOST' : '')
        );
    }

}
