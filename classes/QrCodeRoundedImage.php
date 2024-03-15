<?php

namespace Arikaim\Modules\Qrcode\Classes;

use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QRGdImagePNG;


class QrCodeRoundedImage extends QRGdImagePNG
{

	protected function module(int $x, int $y, int $M_TYPE):void
    {
        $this->options->drawCircularModules = true;

		$neighbours = $this->matrix->checkNeighbours($x, $y);
		$x1         = ($x * $this->scale);
		$y1         = ($y * $this->scale);
		$x2         = (($x + 1) * $this->scale);
		$y2         = (($y + 1) * $this->scale);
		$rectsize   = (int)($this->scale / 2);
		$light      = $this->getModuleValue($M_TYPE);
		$dark       = $this->getModuleValue($M_TYPE | QRMatrix::IS_DARK);

		if (($neighbours & (1 << 7))) { 
			imagefilledrectangle($this->image, $x1, $y1, ($x1 + $rectsize), ($y1 + $rectsize), $light);
			imagefilledrectangle($this->image, $x1, ($y2 - $rectsize), ($x1 + $rectsize), $y2, $light);
		}

		if (($neighbours & (1 << 3))) {
			imagefilledrectangle($this->image, ($x2 - $rectsize), $y1, $x2, ($y1 + $rectsize), $light);
			imagefilledrectangle($this->image, ($x2 - $rectsize), ($y2 - $rectsize), $x2, $y2, $light);
		}

		if (($neighbours & (1 << 1))) {
			imagefilledrectangle($this->image, $x1, $y1, ($x1 + $rectsize), ($y1 + $rectsize), $light);
			imagefilledrectangle($this->image, ($x2 - $rectsize), $y1, $x2, ($y1 + $rectsize), $light);
		}

		if (($neighbours & (1 << 5))) { 
			imagefilledrectangle($this->image, $x1, ($y2 - $rectsize), ($x1 + $rectsize), $y2, $light);
			imagefilledrectangle($this->image, ($x2 - $rectsize), ($y2 - $rectsize), $x2, $y2, $light);
		}

		if (!$this->matrix->check($x,$y)) {

			if (($neighbours & 1) && ($neighbours & (1 << 7)) && ($neighbours & (1 << 1))) {
				imagefilledrectangle($this->image, $x1, $y1, ($x1 + $rectsize), ($y1 + $rectsize), $dark);
			}

			if (($neighbours & (1 << 1)) && ($neighbours & (1 << 2)) && ($neighbours & (1 << 3))) {
				imagefilledrectangle($this->image, ($x2 - $rectsize), $y1, $x2, ($y1 + $rectsize), $dark);
			}

			if (($neighbours & (1 << 7)) && ($neighbours & (1 << 6)) && ($neighbours & (1 << 5))) {
				imagefilledrectangle($this->image, $x1, ($y2 - $rectsize), ($x1 + $rectsize), $y2, $dark);
			}

			if (($neighbours & (1 << 3)) && ($neighbours & (1 << 4)) && ($neighbours & (1 << 5))) {
				imagefilledrectangle($this->image, ($x2 - $rectsize), ($y2 - $rectsize), $x2, $y2, $dark);
			}
		}

		imagefilledellipse(
			$this->image,
			(int)($x * $this->scale + $this->scale / 2),
			(int)($y * $this->scale + $this->scale / 2),
			($this->scale - 1),
			($this->scale - 1),
			$light
		);
	}

}
