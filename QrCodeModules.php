<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Qrcode;

use chillerlan\QRCode\Data\QRMatrix;

use Arikaim\Modules\Image\Classes\Color;

/**
 * QrCodeModules class
 */
class QrCodeModules
{
    const FINDER     = 'finder';
    const ALIGNMENT  = 'alignment';
    const TIMING     = 'timing';
    const FORMAT     = 'format';
    const VERSION    = 'version';
    const DATA       = 'data';
    const DARKMODULE = 'darkmodule';
    const SEPARATOR  = 'separator';
    const QUIETZONE  = 'quietzone';

    const MODULES = [
        Self::FINDER => [
            'dark'  => QRMatrix::M_FINDER_DARK,
            'light' => QRMatrix::M_FINDER
        ],
        Self::ALIGNMENT => [
            'dark'  => QRMatrix::M_ALIGNMENT_DARK,
            'light' => QRMatrix::M_ALIGNMENT
        ],
        Self::TIMING => [
            'dark'  => QRMatrix::M_TIMING_DARK,
            'light' => QRMatrix::M_TIMING
        ],
        Self::FORMAT => [
            'dark'  => QRMatrix::M_FORMAT_DARK,
            'light' => QRMatrix::M_FORMAT
        ],
        Self::VERSION => [
            'dark'  => QRMatrix::M_VERSION_DARK,
            'light' => QRMatrix::M_VERSION
        ],
        Self::DATA => [
            'dark'  => QRMatrix::M_DATA_DARK,
            'light' => QRMatrix::M_DATA
        ],
        Self::DARKMODULE => [
            'dark'  => QRMatrix::M_DARKMODULE,
            'light' => QRMatrix::M_DARKMODULE_LIGHT
        ],
        Self::SEPARATOR => [
            'dark'  => QRMatrix::M_SEPARATOR_DARK,
            'light' => QRMatrix::M_SEPARATOR
        ],
        Self::QUIETZONE => [
            'dark'  => QRMatrix::M_QUIETZONE_DARK,
            'light' => QRMatrix::M_QUIETZONE
        ]
    ];

    /**
     * Content
     *
     * @var array
     */
    protected $content = [];

    /**
     * Image type
     *
     * @var string
     */
    protected $imageType;

    /**
     * Constructor
     *
     * @param string $imageType
     * @param array $content
     */
    public function __construct(string $imageType = 'png', array $content = [])
    {
        $this->content = $content;
        $this->imageType = $imageType;
    }

    /**
     * Get content
     *
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * Create 
     *
     * @param string $imageType
     * @param array $content
     * @return QrCodeModules
     */
    public static function create(string $imageType = 'png', array $content = [])  
    {
        return new Self($imageType,$content);
    }   

    /**
     * Apply modules colors
     *
     * @param array $colors
     * @return void
     */
    public function applyColors(array $colors): void
    {
        foreach ($colors as $key => $value) { 
            $this->color($key,$value);
        }
    } 

    /**
     * Apply module color
     *
     * @param string $moduleName
     * @param mixed $dark
     * @param mixed $light
     * @return QrCodeModules
     */
    public function color(string $moduleName, $dark = null, $light = null)
    {
        if (empty($dark) == false) {
            $index = Self::MODULES[$moduleName]['dark'] ?? null;
            if ($index > 0) {              
                $this->content[$index] = $this->resolveColor($dark);
            }
           
        }
        if (empty($light) == false) {
            $index = Self::MODULES[$moduleName]['light'] ?? null;
            if ($index > 0) {              
                $this->content[$index] = $this->resolveColor($light);
            }           
        }

        return $this;
    }

    /**
     * Resolve color value
     *
     * @param mixed $color
     * @return mixed
     */
    protected function resolveColor($color)
    {
        return ($this->imageType != 'svg') ? Color::hexToRgb($color) : $color;
    }
}
