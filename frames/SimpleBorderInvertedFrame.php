<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Qrcode\Frames;

use Arikaim\Core\Arikaim;
use Arikaim\Modules\Qrcode\Classes\FrameInterface;

/**
 * Qr code simple border inverted frame
 */
class SimpleBorderInvertedFrame implements FrameInterface
{
    /**
     * Render qr code image with frame
     *
     * @param object $image
     * @param array $options
     * @return mixed
     */
    public function render($image, array $options)
    {              
        $width = $image->width() + ($options['borderWidth'] * 2);
		$height = $image->height() + ($options['borderWidth'] * 2) + 40;

        $canvas = Arikaim::getService('image')->manager()->canvas($width,$height,$options['color']);
        $canvas->insert($image,'bottom',$options['borderWidth'],$options['borderWidth']);

        if (empty($options['label']) == false) {
            $canvas->text($options['label'],($width / 2),8,function($font) use($options) {
                $font->file($options['fontFile']);
                $font->size(42);
                $font->align('center');
                $font->valign('top');
                $font->color($options['text_color']);
            });
        }
   
        return $canvas->getCore();
    }

    /**
     * Render frame icon
     *
     * @param integer $width
     * @param integer $height
     * @param string $econdeType
     * @return mixed
    */
    public function renderIcon(int $width, int $height, string $econdeType = 'data-url') 
    {
        $canvas = Arikaim::getService('image')->manager()->canvas($width,$height,'#000');
        $canvas->rectangle(2, 20, ($width - 2),($height - 2), function ($draw) {
            $draw->background('#fff');           
        });
        $canvas->text('SCAN ME',($width / 2),12,function($font) {
            $font->file(1);
            $font->size(42);
            $font->align('center');
            $font->valign('bottom');
            $font->color('#FFF');
        });

        return $canvas->encode($econdeType);
    }
}
