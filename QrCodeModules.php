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
            'dark'  => 1536,
            'light' => 6
        ],
        Self::ALIGNMENT => [
            'dark'  => 2560,
            'light' => 10
        ],
        Self::TIMING => [
            'dark'  => 3072,
            'light' => 12
        ],
        Self::FORMAT => [
            'dark'  => 3584,
            'light' => 14
        ],
        Self::VERSION => [
            'dark'  => 4096,
            'light' => 16
        ],
        Self::DATA => [
            'dark'  => 1024,
            'light' => 4
        ],
        Self::DARKMODULE => [
            'dark'  => 512,
            'light' => 8
        ],
        Self::SEPARATOR => [
            'dark'  => null,
            'light' => 8
        ],
        Self::QUIETZONE => [
            'dark'  => null,
            'light' => 18
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
