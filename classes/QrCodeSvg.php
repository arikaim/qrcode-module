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

use chillerlan\QRCode\Output\QRMarkupSVG;
use chillerlan\Settings\SettingsContainerInterface;
use chillerlan\QRCode\Data\QRMatrix;

/**
 * Qr code svg image 
 */
class QrCodeSvg extends QRMarkupSVG
{
    /**
	 * QROutputAbstract constructor.
	 */
	public function __construct(SettingsContainerInterface $options, QRMatrix $matrix)
    {
        $options['svgAddXmlHeader'] = false;

        parent::__construct($options,$matrix);
    }
}
