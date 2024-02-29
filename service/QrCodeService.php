<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Qrcode\Service;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Zxing\QrReader;

use Arikaim\Core\Service\Service;
use Arikaim\Core\Service\ServiceInterface;
use Arikaim\Modules\Qrcode\Classes\QrCodeFrame;

/**
 * QrCode service class
*/
class QrCodeService extends Service implements ServiceInterface
{
    /**
     * Boot service
     *
     * @return void
     */
    public function boot()
    {
        $this->setServiceName('qrcode');
    }

    /**
     * Decode qr code image
     *
     * @param string $imagePaht
     * @return mixed
     */
    public function decode(string $imagePaht)
    {
        $qrcode = new QrReader($imagePaht);
        
        return $qrcode->text();
    }
   
    /**
     * Render qrcode
     *
     * @param string $data
     * @param array|null $config
     * @return mixed
     */
    public function render(string $data, ?array $config = null)
    {        
        return $this->create($config)->render($data);
    }

    /**
     * Save to file
     *
     * @param string $data
     * @param string $fileName
     * @param array|null $config
     * @return boolean
     */
    public function saveToFile(string $data, string $fileName, ?array $config = null): bool
    {
        $qrcode = $this->create($config);
        $qrcode->render($data,$fileName);

        return (bool)\file_exists($fileName);
    }

    /**
     * Get matrix
     *
     * @param string $data
     * @param mixed $config
     * @return mixed
     */
    public function getMatrix(string $data, $config = null)
    {
        return $this->create($config)->getQRMatrix();
    }

    /**
     * Create qrcode
     *
     * @param mixed $config
     * @return object
    */
    public function create($config = null): object
    {       
        if (\is_object($config) == false) {
            $options = new QROptions($config ?? [
                'version'    => 5,
                'outputType' => QRCode::OUTPUT_MARKUP_SVG,
                'eccLevel'   => QRCode::ECC_L,
            ]);
        } else {
            $options = $config;
        }
       
        return new QRCode($options);
    } 

    /**
     * Create empty qr code image (placeholder)
     *
     * @param integer $scale
     * @param float $opacity
     * @param string $encodeType
     * @return mixed
     */
    public function renderEmpty(int $scale = 5, float $opacity = 0.3, string $encodeType = 'data-url')
    {     
        global $container;

        $resource = $this->render('...',[
            'scale'            => $scale,
            'imageTransparent' => true,
            'outputType'       => 'png',
            'returnResource'   => true
        ]);

        $image = $container->get('service')->get('image')->opacity($resource,$opacity);
    
        return $container->get('service')->get('image')->make($image)->encode($encodeType);     
    }

    /**
     * Render frame icon
     *
     * @param string $name
     * @param integer $width
     * @param integer $height
     * @param string $encodeType
     * @return mixed
     */
    public function renderFrameIcon(string $name, int $width = 64, int $height = 64, string $encodeType = 'data-url')
    {
        return QrCodeFrame::renderIcon($name,$width,$height,$encodeType);
    }
}
