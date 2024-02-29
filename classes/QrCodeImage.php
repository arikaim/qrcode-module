<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Qrcode\Classes;

use chillerlan\QRCode\Output\QRImage;

use Arikaim\Modules\Image\Classes\Color;
use Arikaim\Modules\Qrcode\Classes\QrCodeFrame;

/**
 * Qr code image with optional logo and frame
 */
class QrCodeImage extends QRImage
{
	/**
     * Dump image
     * 
	 * @param string|null $file
     * 
	 * @return string	
	 */
	public function dump(string $file = null):string
    {		
		$this->options->returnResource = true;
        // add logo
        if (empty($this->options->logoFileName) == false) {
            if ($this->isValidLogoSpace() == false) {
                $this->options->logoSpaceWidth = 2;
                $this->options->logoSpaceHeight = 2;
            }  
           
            $this->matrix->setLogoSpace($this->options->logoSpaceWidth,$this->options->logoSpaceHeight);
        }

        parent::dump($file);

        // set bg color
        if (empty($this->options->bgColor) == false) {                    
            $color = Color::hexToRgb($this->options->bgColor);
            \imagefilter($this->image,IMG_FILTER_COLORIZE,$color[0],$color[1],$color[2]);         
        }

        // add logo
        if (empty($this->options->logoFileName) == false) {
            $this->addLogoImage($this->options->logoFileName);
        }
        
        if (\is_array($this->options->frame) == true) {
            $this->options->frame['scale'] = $this->options->scale;
            $this->options->frame['fontPath'] = $this->options->fontPath;
            $frame = new QrCodeFrame($this->image,$this->options->frame);
            $this->image = $frame->render();
        }
      
		$imageData = $this->dumpImage();

		if ($file !== null) {
			$this->saveToFile($imageData,$file);
		}

		if ($this->options->imageBase64) {
			$imageData = 'data:image/' . $this->options->outputType . ';base64,' . \base64_encode($imageData);
		}

		return $imageData;
	}

  

    /**
     * Retrun true if logo space is valid
     *
     * @return boolean
     */
    protected function isValidLogoSpace(): bool
    {
        $length = $this->options->version * 4 + 17;
        $size = $this->options->logoSpaceWidth * $this->options->logoSpaceHeight;

		return ($size > floor($length * $length * 0.2)) ? false : true;		
    }

    /**
     * Add logo image
     *
     * @param string $fileName
     * @return void
     */
    protected function addLogoImage(string $fileName, ?int $spaceX = null, ?int $spaceY = null): void
    {       
		$logoImage = \imagecreatefrompng($fileName);

		// get logo image size
		$width = \imagesx($logoImage);
		$height = \imagesy($logoImage);
		$leftWidth = (int)(($this->options->logoSpaceWidth - 2) * $this->options->scale);
		$leftHeigth = (int)(($this->options->logoSpaceHeight - 2) * $this->options->scale);
        $spaceX = $spaceX ?? 0;
        $spaceY = $spaceY ?? 0;

		$size = $this->matrix->size() * $this->options->scale;
        $destinationX = (int)((($size - $leftWidth) / 2) + $spaceX);
        $destinationY = (int)((($size - $leftHeigth) / 2) + $spaceY);

		\imagecopyresampled($this->image,$logoImage,$destinationX,$destinationY,0,0,$leftWidth,$leftHeigth,$width,$height);                           
    }
}
