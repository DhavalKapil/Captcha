<?php

/**
 * @class to generate the captcha Image
 */
class Image
{
    /**
     * The text to be written in captcha
     *
     * @var string
     */
    protected $text;

	/**
	 * Url of font file
	 *
	 * @var string
	 */
	protected $font;

	/**
	 * Size of font
	 *
	 * @var number
	 */
	protected $fontSize;

	/**
	 * Padding between text and boundary
	 *
	 * @var number
	 */
	protected $padding;

	/**
	 * Width of the container
	 *
	 * @var number
	 */
	protected $containerWidth;

	/**
	 * Height of the container
	 *
	 * @var number
	 */
	protected $containerHeight;

    /**
     * x coordinate of text in image
     *
     * @var number
     */
    protected $textX;

    /**
     * y coordinate of text in image
     *
     * @var number
     */
    protected $textY;

	/**
	 * Hex of the background color
	 *
	 * @var string
	 */
	protected $backgroundColor;

	/**
	 * Hex of the text color
	 *
	 * @var string
	 */
	protected $textColor;

	/**
	 * Angle of text with respect to the container
	 *
	 * @var number
	 */
	protected $angle;

    /**
     * Array of lines to be inserted
     *
     * @var array
     */
    protected $lines;

    /**
     * The captcha image
     *
     * @var resource
     */
    protected $captchaImage;

    /**
     * Public constructor
     */
    public function __construct($text = NULL, $font = NULL, $fontSize = NULL, $padding = NULL, $backgroundColor = NULL, $textColor = NULL, $angle = NULL, $lines = NULL)
    {
        if(NULL === $text)
        {
            $text = "Test!";
        }

        if(NULL === $font)
        {
            $font = __DIR__."/../fonts/LucidaBrightRegular.ttf";
        }

        if(NULL === $fontSize)
        {
            $fontSize = 18;
        }

        if(NULL === $padding)
        {
            $padding = 20;
        }

        if(NULL === $backgroundColor)
        {
            $backgroundColor = "#225588";
        }

        if(NULL === $textColor)
        {
            $textColor = "#aa7744";
        }

        if(NULL === $angle)
        {
            $angle = 10;
        }

        $this->text = $text;
        $this->font = $font;
        $this->fontSize = $fontSize;
        $this->padding = $padding;
        $this->backgroundColor = $backgroundColor;
        $this->textColor = $textColor;
        $this->angle = $angle;
        $this->lines = $lines;

        // Generating the image
        $this->generateImage();
    }

    /**
     * All the getter and setter functions
     */
    public function getText()
    {
        return $this->text;
    }

    public function setText()
    {
        $this->text = $text;

        // Generating the new image
        $this->generateImage();
    }

    public function getFont()
    {
        return $this->font;
    }

    public function setFont($font)
    {
        $this->font = $font;

        // Generating the new image
        $this->generateImage();
    }

    public function getFontSize()
    {
        return $this->fontSize;
    }

    public function setFontSize($fontSize)
    {
        $this->fontSize = $fontSize;

        // Generating the new image
        $this->generateImage();
    }

    public function getPadding()
    {
        return $this->padding;
    }

    public function setPadding($padding)
    {
        $this->padding = $padding;

        // Generating the new image
        $this->generateImage();
    }

    public function getContainerWidth()
    {
        return $this->containerWidth;
    }

    public function getContainerHeight()
    {
        return $this->containerHeight;
    }

    public function getTextX()
    {
        return $this->textX;
    }

    public function getTextY()
    {
        return $this->textY;
    }

    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;

        // Generating the new image
        $this->generateImage();
    }

    public function getTextColor()
    {
        return $this->textColor;
    }

    public function setTextColor($textColor)
    {
        $this->textColor = $textColor;

        // Generating the new image
        $this->generateImage();
    }

    public function getAngle()
    {
        return $this->angle;
    }

    public function setAngle($angle)
    {
        $this->angle = $angle;

        // Generating the new image
        $this->generateImage();
    }

    public function getLines()
    {
        return $this->lines;
    }

    public function setLines($lines)
    {
        $this->lines = $lines;

        // Generating the new image
        $this->generateImage();
    }

    public function getCaptchaImage()
    {
        return $this->captchaImage;
    }

    /**
     * Function for making colors
     *
     * @param string $color specifies the hex of the color
     */
    private function makeColor($color)
    {
        $color = str_replace("#", "", $color);
        $redComponent = hexdec(substr($color, 0, 2));
        $greenComponent = hexdec(substr($color, 2, 2));
        $blueComponent = hexdec(substr($color, 4, 2));

        // Allocating color to image
        $colorIdentifier = imagecolorallocate($this->captchaImage, $redComponent, $greenComponent, $blueComponent);

        return $colorIdentifier;
    }

    /**
     * Function to make a box where text will fit in
     */
    private function makeBox()
    {
        $wordBox = imageftbbox($this->fontSize, 0, $this->font, $this->text);

        $wordBoxWidth = $wordBox[2];
        $wordBoxHeight = $wordBox[1] + abs($wordBox[7]);

        // Setting box properties
        $this->containerWidth = $wordBoxWidth + ($this->padding * 2);
        $this->containerHeight = $wordBoxHeight + ($this->padding * 2);
        $this->textX = $this->padding;
        $this->textY = $this->containerHeight - $this->padding;
    }

    /**
     * Function to create the image
     */
    private function createImage()
    {
        // Creatint the image
        $this->captchaImage = imagecreate($this->containerWidth, $this->containerHeight);

        // Creating the colors
        $backgroundColor = $this->makeColor($this->backgroundColor);
        $textColor = $this->makeColor($this->textColor);

        // Adding text
        imagefttext($this->captchaImage, $this->fontSize, 0, $this->textX, $this->textY, $textColor, $this->font, $this->text);

        // Rotating image
        $this->captchaImage = imagerotate($this->captchaImage, $this->angle, $backgroundColor);
    }


    /**
     * Function to add lines in captcha
     */
    private function addLines()
    {
        foreach($this->lines as $line)
        {
            $lineColor = $this->makeColor($line->getColor(), $this->captchaImage);

            // Adding line
            imageline($this->captchaImage, $line->getXStart(), $line->getYStart(), $line->getXEnd(), $line->getYEnd(), $lineColor);
        }
    }

    /**
     * Function to call all above functions and output the image
     */
    public function generateImage()
    {
        $this->makeBox();
        $this->createImage();
        $this->addLines();
    }

    /**
     * Function to render the image
     */
    public function renderImage()
    {
        // Sending content-type header
        header('Content-Type:image/png');

        imagepng($this->captchaImage);
    }}