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

use Arikaim\Core\Extension\Module;

/**
 * QrCode module class
 */
class QrCode extends Module
{
    /**
     *  EEC index map 
     */
    const ECC_INDEX = [
        'L' => 0,
        'M' => 1,
        'Q' => 2,
        'H' => 3
    ];

    /**
     *  Default output handler class
     */
    const DEFAULT_OUTPUT_HANDLER = \Arikaim\Modules\Qrcode\Classes\QrCodeImage::class;

    /**
     * Qrcode output hanlders
     */
    const OUTPUT_HANDLERS = [
        'image' => Self::DEFAULT_OUTPUT_HANDLER,
        'svg'   => \Arikaim\Modules\Qrcode\Classes\QrCodeSvg::class,
    ];

    /**
     * Install module
     *
     * @return void
     */
    public function install()
    {
        $this->registerService('QrCodeService');
    }

    /**
     * Gte output hanlder class
     *
     * @param string|null $name
     * @return string
     */
    public static function getOutputHandlerClass(?string $name): string
    {
        return Self::OUTPUT_HANDLERS[$name ?? 'image'] ?? Self::DEFAULT_OUTPUT_HANDLER;
    }

    /**
     * Create qrcode hanlder
     *
     * @param string|null $name
     * @param mixed      $options
     * @param mixed      $matrix
     * @return object
     */
    public static function createOutputHandler(?string $name, $options, $matrix): object
    {
        $class = Self::getOutputHandlerClass($name);

        return new $class($options,$matrix);
    }

    /**
     * Get EEC value
     *
     * @param string|int $key
     * @return integer|null
     */
    public static function getECC($key = 0): ?int
    {
        $index = (\is_numeric($key) == true) ? $key : Self::ECC_INDEX[$key] ?? null;
        
        return $index;
    }
}
