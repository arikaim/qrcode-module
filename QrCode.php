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
     * Install module
     *
     * @return void
     */
    public function install()
    {
        $this->registerService('QrCodeService');
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
        
        return \chillerlan\QRCode\QRCode::ECC_MODES[$index] ?? null; 
    }
}
