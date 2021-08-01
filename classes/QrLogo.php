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

/**
 * Qr code image with logo
 */
class QrLogo extends QRImage
{
	/**
     * Dump image
     * 
	 * @param string|null $file
	 * @param string|null $logo
	 *
	 * @return string|null	
	 */
	public function dump(?string $file = null, ?string $logo = null): ?string
    {		
		$this->options->returnResource = true;
        // add logo
        if (empty($logo) == false) {
            $this->matrix->setLogoSpace(
                $this->options->logoSpaceWidth,
                $this->options->logoSpaceHeight			
            );
        }

        parent::dump($file);

        // set bg color
        if (empty($this->options->bgColor) == false) {                    
            $color = Color::hexToRgb($this->options->bgColor);
            \imagefilter($this->image,IMG_FILTER_COLORIZE,$color[0],$color[1],$color[2]);         
        }

        // add logo
        if (empty($logo) == false) {
            $this->addLogoImage($logo);
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
     * Add logo image
     *
     * @param string|null $logo
     * @return void
     */
    protected function addLogoImage(?string $logo): void
    {       
		$logoImage = \imagecreatefrompng($logo);

		// get logo image size
		$width = \imagesx($logoImage);
		$height = \imagesy($logoImage);
		$leftWidth = ($this->options->logoSpaceWidth - 2) * $this->options->scale;
		$leftHeigth = ($this->options->logoSpaceHeight - 2) * $this->options->scale;
        $spaceX = 7;
        $spaceY = 7;

		$size = $this->matrix->size() * $this->options->scale;
        $destinationX = (($size - $leftWidth) / 2) + $spaceX;
        $destinationY = (($size - $leftHeigth) / 2) + $spaceY;

		\imagecopyresampled($this->image,$logoImage,$destinationX,$destinationY,0,0,$leftWidth,$leftHeigth,$width,$height);                        
    }
}
