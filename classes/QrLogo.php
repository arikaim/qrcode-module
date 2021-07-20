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
use Exception;

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
	 * @throws Exception
	 */
	public function dump(string $file = null, string $logo = null): ?string
    {		
		$this->options->returnResource = true;
		
		if (!\is_file($logo) || !\is_readable($logo)) {
			throw new Exception('Invalid logo image');
            return null;
		}

		$this->matrix->setLogoSpace(
			$this->options->logoSpaceWidth,
			$this->options->logoSpaceHeight			
		);

		parent::dump($file);
		$image = \imagecreatefrompng($logo);

		// get logo image size
		$width = \imagesx($image);
		$height = \imagesy($image);
		$leftWidth = ($this->options->logoSpaceWidth - 2) * $this->options->scale;
		$leftHeigth = ($this->options->logoSpaceHeight - 2) * $this->options->scale;

		$scale = $this->matrix->size() * $this->options->scale;
	
		\imagecopyresampled(
            $this->image,
            $image,
            ($scale - $leftWidth) / 2,
            ($scale - $leftHeigth) / 2,0,0,$leftWidth,$leftHeigth,$width,$height);

		$imageData = $this->dumpImage();

		if ($file !== null) {
			$this->saveToFile($imageData,$file);
		}

		if ($this->options->imageBase64) {
			$imageData = 'data:image/' . $this->options->outputType.';base64,' . \base64_encode($imageData);
		}

		return $imageData;
	}
}
