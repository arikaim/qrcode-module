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

/**
 * Qr code frame interface
 */
interface FrameInterface 
{
    /**
     * Render frame icon
     *
     * @param integer $width
     * @param integer $height
     * @param string $econdeType
     * @return mixed
     */
    public function renderIcon(int $width, int $height, string $econdeType = 'data-url');

    /**
     * Render qr code image with frame
     *
     * @param object $image
     * @param array $options
     * @return mixed
     */
    public function render($image, array $options);
}
