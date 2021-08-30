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

use Arikaim\Core\Arikaim;
use Arikaim\Core\Utils\Path;

/**
 * Qr code frame
 */
class QrCodeFrame 
{
    const FRAME_CLASSES = [
        'simple-border'          => 'Arikaim\Modules\Qrcode\Frames\SimpleBorderFrame',
        'simple-border-inverted' => 'Arikaim\Modules\Qrcode\Frames\SimpleBorderInvertedFrame'
    ];

    /**
     * Image resource
     *
     * @var mixed
     */
    public $image = null;

    /**
     * Frame options
     *
     * @var array
     */
    public $options = [];

    /**
     * Constructor
     *
     * @param resource $imageSource
     * @param array $options
     */
    public function __construct($imageSource, array $options)
    {      
        $this->options = $this->resolveOptions($options);
        $this->image = Arikaim::getService('image')->make($imageSource);
    }

    /**
     * Render frame
     *
     * @return mixed
     */
    public function render()
    {
        $type = $this->options['type'] ?? null;
        $class = Self::FRAME_CLASSES[$type] ?? null;
        if (empty($class) == true) {
            return $this->image->getCore();
        }

        $frame = new $class();

        return $frame->render($this->image,$this->options);       
    }   

    /**
     * Render icon
     *
     * @param string $name
     * @param integer $width
     * @param integer $height
     * @param string $encodeType
     * @return void
     */
    public static function renderIcon(string $name, int $width = 64, int $height = 64, string $encodeType = 'data-url')
    {       
        $class = Self::FRAME_CLASSES[$name] ?? null;
        if (empty($class) == true) {
            $emptyIcon = Arikaim::getService('image')->manager()->canvas($width,$height,'#000');

            return $emptyIcon->encode($encodeType);
        }

        $frame = new $class();

        return $frame->renderIcon($width,$height,$encodeType);
    }

    /**
     * Resolve options
     *
     * @param array $options
     * @return array
     */
    protected function resolveOptions(array $options): array
    {
        $options['scale'] = empty($options['scale'] ?? null) ? 5 : $options['scale']; 
        $options['font'] = empty($options['font'] ?? null) ? 'ostrich-sans-black.ttf' : $options['font']; 
        $options['fontPath'] = empty($options['fontPath'] ?? null) ? Path::STORAGE_PATH . 'fonts' . DIRECTORY_SEPARATOR : $options['fontPath']; 
        $options['fontFile'] = $options['fontPath'] . $options['font'];
        $options['fontSize'] = 8 * $options['scale'];
        $options['fontSize'] = ($options['fontSize'] > 42) ? 42 : $options['fontSize'];

        $options['label'] = $options['label'] ?? 'SCAN ME';
        $options['color'] = empty($options['color'] ?? null) ? '#000' : $options['color'];
        $options['text_color'] = empty($options['text_color'] ?? null) ? '#fff' : $options['text_color'];
        $options['borderWidth'] = empty($options['borderWidth'] ?? null) ? 5 : $options['borderWidth']; 

        return $options;
    }
}
