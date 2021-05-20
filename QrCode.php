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
     * Install module
     *
     * @return void
     */
    public function install()
    {
        $this->registerService('QrCodeService');
    }
}
