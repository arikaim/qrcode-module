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
     * Constructor
     */
    public function __construct()
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
        $qrcode = $this->create($config);

        return (\is_object($qrcode) == true) ? $qrcode->render($data) : null;
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
        if (\is_object($qrcode) == false) {
            return false;
        }

        $qrcode->render($data,$fileName);

        return (bool)\file_exists($fileName);
    }

    /**
     * Get matrix
     *
     * @param string $data
     * @param array|null $config
     * @return mixed
     */
    public function getMatrix(string $data, ?array $config = null)
    {
        $qrcode = $this->create($config);

        return (\is_object($qrcode) == true) ? $qrcode->getMatrix($data) : null; 
    }

    /**
     * Create qrcode
     *
     * @param array|null $config
     * @return mixed
    */
    public function create(?array $config = null)
    {       
        $options = new QROptions($config ?? [
            'version'    => 5,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel'   => QRCode::ECC_L,
        ]);
     
        return new QRCode($options);
    } 

    /**
     * Render frame icon
     *
     * @param string $name
     * @param integer $width
     * @param integer $height
     * @param string $encodeType
     * @return void
     */
    public function renderFrameIcon(string $name, int $width = 64, int $height = 64, string $encodeType = 'data-url')
    {
        return QrCodeFrame::renderIcon($name,$width,$height,$encodeType);
    }
}
