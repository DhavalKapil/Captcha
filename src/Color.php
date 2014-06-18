<?php

/**
 * @class to represent a color
 */
class Color
{
	/**
	 * The red component (0-255)
	 *
	 * @var number
	 */
	protected $red;

	/**
	 * The green component (0-255)
	 *
	 * @var number
	 */
	protected $green;

	/**
	 * The blue componenet (0-255)
	 *
	 * @var number
	 */
	protected $blue;

	/**
	 * Specifies the lightness according to Lab color space
	 *
	 * @var number
	 */
	protected $L;

	/**
	 * color opponent dimension 'a'
	 *
	 * @var number
	 */
	protected $a;

	/**
	 * color opponent dimension 'b'
	 *
	 * @var number
	 */
	protected $b;

	/**
	 * Public constructor to set up data variables
	 */
	public function __construct($red, $green, $blue)
	{
		$this->red = $red;
		$this->green = $green;
		$this->blue = $blue;

		$this->rgbToLab();
	}

	/**
	 * Function that creates an object from a hex coded string
	 */
	public static function getColorByHexCode($hexCode)
	{
		$hexCode = str_replace("#", "", $hexCode);

        $red = hexdec(substr($hexCode, 0, 2));
        $green = hexdec(substr($hexCode, 2, 2));
        $blue = hexdec(substr($hexCode, 4, 2));

        return new static($red, $green, $blue);
	}
	/**
	 * Function that generates a random color object
	 */
	public static function getRandomColor()
	{
		$red = rand(0, 255);
		$green = rand(0, 255);
		$blue = rand(0, 255);

		return new static($red, $green, $blue);
	}

	/**
	 * Required getters
	 */

	public function getRed()
	{
		return $this->red;
	}

	public function getGreen()
	{
		return $this->green;
	}

	public function getBlue()
	{
		return $this->blue;
	}

	public function getL()
	{
		return $this->L;
	}

	public function getA()
	{
		return $this->a;
	}

	public function getB()
	{
		return $this->b;
	}

	/**
	 * function use to set up Lab variables
	 */
	private function rgbToLab()
	{
		// First converting RGB to XYZ

		$var_R = ( $this->red / 255 );
		$var_G = ( $this->green / 255 );
		$var_B = ( $this->blue / 255 );

		if ( $var_R > 0.04045 ) 
			$var_R = pow( ( ( $var_R + 0.055 ) / 1.055 ) , 2.4 );
		else
		    $var_R = $var_R / 12.92;
		if ( $var_G > 0.04045 ) 
			$var_G = pow( ( ( $var_G + 0.055 ) / 1.055 ) , 2.4 );
		else                   
			$var_G = $var_G / 12.92;
		if ( $var_B > 0.04045 ) 
			$var_B = pow( ( ( $var_B + 0.055 ) / 1.055 ) , 2.4 );
		else                   
			$var_B = $var_B / 12.92;

		$var_R = $var_R * 100;
		$var_G = $var_G * 100;
		$var_B = $var_B * 100;

		$X = $var_R * 0.4124 + $var_G * 0.3576 + $var_B * 0.1805;
		$Y = $var_R * 0.2126 + $var_G * 0.7152 + $var_B * 0.0722;
		$Z = $var_R * 0.0193 + $var_G * 0.1192 + $var_B * 0.9505;


		// Now converting XYZ to Lba

		$var_X = $X / 95.047;
		$var_Y = $Y / 100.000;
		$var_Z = $Z / 108.883;

		if ( $var_X > 0.008856 ) 
			$var_X = pow( $var_X , ( 1/3 ) );
		else                    
			$var_X = ( 7.787 * $var_X ) + ( 16 / 116 );
		if ( $var_Y > 0.008856 ) 
			$var_Y = pow( $var_Y , ( 1/3 ) );
		else                    
			$var_Y = ( 7.787 * $var_Y ) + ( 16 / 116 );
		if ( $var_Z > 0.008856 ) 
			$var_Z = pow( $var_Z , ( 1/3 ) );
		else                    
			$var_Z = ( 7.787 * $var_Z ) + ( 16 / 116 );

		$this->L = ( 116 * $var_Y ) - 16;
		$this->a = 500 * ( $var_X - $var_Y );
		$this->b = 200 * ( $var_Y - $var_Z );
	}

	/**
	 * Function used to calculate the distance metric between two colors
	 */
	public static function getDistanceMetric($color1, $color2)
	{
		$temp = pow( $color1->getL() - $color2->getL() , 2 );
		$temp += pow( $color1->getA() - $color2->getA() , 2 );
		$temp = pow( $color1->getB() - $color2->getB() , 2 );

		$temp = sqrt($temp);

		return $temp;
	}

	/**
	 * Function that checks whether two colors are noticeable or not
	 *
	 * @return boolean
	 */
	public static function areNoticeable($color1, $color2)
	{
		if(Color::getDistanceMetric($color1, $color2) >= 50)	// 2.3 according to standards
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}