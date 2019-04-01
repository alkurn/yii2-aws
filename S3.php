<?php
/**
 * @copyright Ganesh alkurn
 * @author Ganesh alkurn <mganesh.alkurn@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 * @package yii2-aws
 */
namespace aws\S3;

use yii\base\Component;
use Aws;

/**
 * Yii2 component wrapping of the AWS SDK for easy configuration
 * @author Federico Nicolás Motta <fedemotta@gmail.com>
 */
class S3 extends Component
{
    /*
     * @var array specifies the AWS credentials
     */
    public $credentials = [];
    
    /*
     * @var string specifies the AWS region
     */
    public $region = null;
    
    /*
     * @var string specifies the AWS version
     */
    public $version = null;

    /*
     * @var string specifies the AWS bucket
     */
    public $bucket = null;

    /*
     * @var array specifies extra params
     */
    public $extra = [];
    
    /**
     * @var Aws\Sdk instance
     */
    protected $_s3;
    
    /**
     * Initializes (if needed) and fetches the AWS SDK instance
     * @return Aws\Sdk instance
     */
    public function getS3()
    {
        if (empty($this->_s3) || !$this->_s3 instanceof Aws\Sdk) {
            $this->setS3();
        }
        return $this->_s3;
    }
    /**
     * Sets the AWS SDK instance
     */
    public function setS3()
    {
        $this->_s3 = new Aws\Sdk(array_merge([
                                        'credentials' => $this->credentials,
                                        'region' => $this->region,
                                        'version' => $this->version
                                    ],$this->extra));
    }
}
