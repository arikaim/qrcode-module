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
	 * @return string|null	
	 */
	public function dump(?string $file = null): ?string
    {		
		$this->options->returnResource = true;
        // add logo
        if (empty($this->options->logoFileName) == false) {
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
        if (empty($this->options->logoFileName) == false) {
            $this->addLogoImage($this->options->logoFileName);
        }
        
        if (\is_array($this->options->frame) == true) {
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
     * Add logo image
     *
     * @param string $fileName
     * @return void
     */
    protected function addLogoImage(string $fileName): void
    {       
		$logoImage = \imagecreatefrompng($fileName);

		// get logo image size
		$width = \imagesx($logoImage);
		$height = \imagesy($logoImage);
		$leftWidth = ($this->options->logoSpaceWidth - 2) * $this->options->scale;
		$leftHeigth = ($this->options->logoSpaceHeight - 2) * $this->options->scale;
        $spaceX = 0;
        $spaceY = 0;

		$size = $this->matrix->size() * $this->options->scale;
        $destinationX = (($size - $leftWidth) / 2) + $spaceX;
        $destinationY = (($size - $leftHeigth) / 2) + $spaceY;

		\imagecopyresampled($this->image,$logoImage,$destinationX,$destinationY,0,0,$leftWidth,$leftHeigth,$width,$height);                        
    }
}
