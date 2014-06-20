<?php

/**
 * @class that handles all the details of the CAPTCHA
 */
class Captcha
{
	/**
	 * The image of the captcha
	 *
	 * @var Image
	 */
	protected $image;

	/**
	 * The lines to be added in the image
	 *
	 * @var array
	 */
	protected $lines;

	/**
	 * public constructor
	 */
	public function __construct($image=NULL, $lines=NULL)
	{
		if(NULL == $image)
		{
			$this->image = new Image;
		}
		else
		{
			$this->image = $image;
		}

		if(NULL != $lines)
		{
			$this->lines = $lines;
			$this->image->setLines($lines);
		}
	}

	/**
	 * Getters and setters
	 */
	public function getImage()
	{
		return $this->image;
	}

	public function setImage($image)
	{
		$this->image = $image;
	}

	public function getLines()
	{
		return $this->lines;
	}

	public function setLines($lines)
	{
		$this->lines = $lines;
		$this->image->setLines($lines);
	}

	/**
	 * Function to add random lines
	 *
	 * @param number $noOfLines - the no of lines and Color $color for setting the color
	 */
	public function addLines($noOfLines, $color=NULL)
	{
		$lines = array();

		for($i = 0;$i<$noOfLines;$i++)
		{
			$line = new Line;

			if(NULL == $color)
			{	
				$line->setColor(Color::getRandomColor());
			}
			else
			{
				$line->setColor($color);
			}

			$line->randomize(0, $this->image->getContainerWidth(), 0, $this->image->getContainerHeight());

			array_push($lines, $line);
		}

		if(NULL == $this->lines)
		{
			$this->lines = $lines;
		}
		else
		{
			$this->lines = array_merge($this->lines, $lines);
		}

		$this->image->setLines($this->lines);
	}

	/**
	 * Function to display the CAPTCHA
	 *
	 * @param bool $adjust that tells whether to adjust the background color to make CAPTCHA more visible
	 */
	public function displayCaptcha($adjust=FALSE)
	{
		if(TRUE == $adjust)
		{
			$this->image->adjustBackgroundColor();
		}

		$this->image->renderImage();
	}

}