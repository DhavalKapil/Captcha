<?php

/**
 * @class to generate the a line in captcha image
 */

class Line
{
	/**
	 * Hex of the line color
	 *
	 * @var Color
	 */
	protected $color;

	/**
	 * x co-ordinate of starting point
	 *
	 * @var number
	 */
	protected $xStart;

	/**
	 * y co-ordinate of starting point
	 *
	 * @var number
	 */
	protected $yStart;

	/**
	 * x co-ordinate of ending point
	 *
	 * @var number
	 */
	protected $xEnd;

	/**
	 * y co-ordinate of ending point
	 *
	 * @var number
	 */
	protected $yEnd;

	/**
	 * Public constructor to initialize all above data values
	 */
	public function __construct($color = NULL, $xStart = NULL, $yStart = NULL, $xEnd = NULL, $yEnd = NULL)
	{
		$this->color = $color;
		$this->xStart = $xStart;
		$this->yStart = $yStart;
		$this->xEnd = $xEnd;
		$this->yEnd = $yEnd;
	}

	/**
	 * All the getter and setter functions
	 */
	public function getColor()
	{
        return $this->color;
    }

    public function setColor($color)
    {
        $this->color = $color;
    }

    public function getXStart()
    {
        return $this->xStart;
    }

    public function setXStart($xStart)
    {
        $this->xStart = $xStart;
    }

    public function getYStart()
    {
        return $this->yStart;
    }

    public function setYStart($yStart)
    {
        $this->yStart = $yStart;
    }

    public function getXEnd()
    {
        return $this->xEnd;
    }

    public function setXEnd($xEnd)
    {
        $this->xEnd = $xEnd;
    }

    public function getYEnd()
    {
        return $this->yEnd;
    }

    public function setYEnd($yEnd)
    {
        $this->yEnd = $yEnd;
    }

    /**
     * Function to randomize the the position of the line
     *
     * @param $xMin, $xMax, $yMin and $yMax are the minimum and maximum co-ordinates availiable
     */
    public function randomize($xMin, $xMax, $yMin, $yMax)
    {
    	$this->xStart = rand($xMin, $xMax);
    	$this->xEnd = rand($xMin, $xMax);
    	$this->yStart = rand($yMin, $yMax);
    	$this->yEnd = rand($yMin, $yMax);
    }
}