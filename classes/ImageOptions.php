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
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QROutputInterface;

use Arikaim\Modules\Qrcode\QrCode as QrCodeMudule;

/**
 * Qr code logo image options
 */
class ImageOptions extends QROptions
{
    /**
     * space height
     *
     * @var int|null
     */
    public ?int $logoSpaceWidth;
	
    /**
     * Space width
     *
     * @var int|null
     */
    public ?int $logoSpaceHeight;

    /**
     * Background color
     *
     * @var mixed
     */
    public $bgColor = null;

    /**
     * Logo file name
     *
     * @var string|null
     */
    public $logoFileName = null;

    /**
     * Frame options
     *
     * @var array|null
     */
    public $frame = null;

    /**
     * Gd image font path
     *
     * @var string|null
     */
    public $fontPath = null;

    /**
     * Draw circle pixels
     *
     * @var boolean
     */
    public bool $drawCircularModules = false;

    /**
     * Keep square modules
     *
     * @var array
     */
    public array $keepAsSquare = [];

    /**
     *  Pixel circle radius
     *
     * @var float
     */
    public float $circleRadius;

    /**
     * Constructor
     *
     * @param array|null $options
     */
    public function __construct(?array $options = null)
    {
        if (\is_array($options) == true) {
            $this->outputType = QROutputInterface::CUSTOM;
            $this->outputInterface = QrCodeMudule::getOutputHandlerClass($options['handler'] ?? null);
            $this->eccLevel = $options['eccLevel'] ?? QRCode::ECC_H;
            $this->version = $options['version'] ?? 7;  
            $this->quality = $options['quality'] ?? 100;                         
            $this->imageBase64 = $options['imageBase64'] ?? true;
            $this->logoSpaceWidth   = $options['space_width'] ?? 10;
            $this->logoSpaceHeight  = $options['space_height'] ?? 10;
            $this->scale            = $options['scale'] ?? 10;
            $this->imageTransparent = $options['transparent'] ?? false;
            $this->bgColor = $options['bgColor'] ?? [255, 255, 255];
            $this->logoFileName = $options['logoFileName'] ?? null;
            $this->frame = $options['frame'] ?? null;
            $this->drawCircularModules = $options['drawCircularModules'] ?? false;
            $this->drawLightModules = $options['drawLightModules'] ?? true;    
            $this->keepAsSquare = $options['keepAsSquare'] ?? [
                QRMatrix::M_FINDER_DARK,
                QRMatrix::M_FINDER_DOT,
                QRMatrix::M_ALIGNMENT_DARK,
            ];
            $this->fontPath = $options['fontPath'] ?? null;
            $this->circleRadius = $options['circleRadius'] ?? 0.5;
        }

        parent::__construct($options);
    } 
}
