<?php

namespace Arikaim\Modules\Qrcode\Classes;

use chillerlan\QRCode\Output\QRImagick;
use Imagick, ImagickPixel;


class QrCodeBackgroundImage extends QRImagick
{

	protected function getDefaultModuleValue(bool $isDark): ImagickPixel
    {
		return $this->prepareModuleValue(($isDark) ? '#00000040' : '#ffffffa0');
	}


	protected function createImage(): Imagick
    {
		$imagick = new Imagick($this->options->background);
		$width   = $imagick->getImageWidth();
		$height  = $imagick->getImageHeight();

		if (($width / $height) !== 1) {
			$cropsize = ($width > $height) ? $height : $width;
			$imagick->cropImage($cropsize,$cropsize,0,0);
		}

		if ($imagick->getImageWidth() !== $this->length) {
			$imagick->scaleImage($this->length,$this->length,true);
		}

		if ($this->options->quality > -1) {
			$imagick->setImageCompressionQuality(max(0,min(100,$this->options->quality)));
		}

		return $imagick;
	}
}
