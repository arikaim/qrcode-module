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
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\QRCode;

/**
 * Qr code logo image options
 */
class LogoOptions extends QROptions
{
    /**
     * space height
     *
     * @var int
     */
    protected $logoSpaceWidth;
	
    /**
     * Space width
     *
     * @var int
     */
    protected $logoSpaceHeight;

    /**
     * Constructor
     *
     * @param array|null $options
     */
    public function __construct(?array $options = null)
    {
        $this->eccLevel = QRCode::ECC_H;

        if (\is_array($options) == true) {
            $this->version = $options['version'] ?? 7;            
            $this->imageBase64 = $options['imageBase64'];
            $this->logoSpaceWidth   = $options['space_width'] ?? 10;
            $this->logoSpaceHeight  = $options['space_height'] ?? 10;
            $this->scale            = $options['scale'] ?? 5;
            $this->imageTransparent = $options['transparent'] ?? false;
        }
    } 
}
