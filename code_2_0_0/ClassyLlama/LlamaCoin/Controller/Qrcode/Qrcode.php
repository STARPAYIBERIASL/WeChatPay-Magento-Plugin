<?php

namespace ClassyLlama\LlamaCoin\Controller\Qrcode;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Qrcode extends \Magento\Framework\App\Action\Action
{
	// protected $helperData;

	/**
     * @var
     */
    private $logger;

    /**
     * @var
     */
    private $logger_custom;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
        \Psr\Log\LoggerInterface $logger,
		\ClassyLlama\LlamaCoin\Logger\Log $logger_custom,
		$name = null)
	{
        $this->logger = $logger;
        $this->logger_custom = $logger_custom;
		parent::__construct($context);
	}

	public function execute()
	{
		require_once 'lib/StarpayUtil.php';

        $this->logger->alert('Mensaje Alerta');
        $this->logger->critical('Mensaje Crítico');
        $this->logger->debug('Mensaje Debug');
        $this->logger->emergency('Mensaje Emergencia');
        $this->logger->error('Mensaje Error');
        $this->logger->info('Mensaje Info');
        $this->logger->notice('Mensaje Notice');
        $this->logger->warning('Mensaje Warning');

        $this->logger->log(\Psr\Log\LogLevel::INFO, 'Mensaje Log');

        $this->logger_custom->info('Estoy en el qrqoce');

		//Wechat interface
		$gatewayurl="https://api.starpayes.com/aps-gateway/entry.do";

		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$cart = $objectManager->get('\Magento\Checkout\Model\Cart');

		$quote_id = $cart->getQuote()->getId();
		$base_url = $objectManager->get('\Magento\Store\Model\StoreManagerInterface')->getStore()->getBaseUrl();

		$timestamp = date('Y-m-d H:i:s');
		// $timestamp = date('2019-07-15 18:28:05');
		$bgRetUrl = $base_url."llamacoin/qrcode/notify";
        $this->logger_custom->info('URL de retorno: '.$bgRetUrl);
		$orderID = $this->generateRandomString()."&".$quote_id;
        $this->logger_custom->info('Order NO: '.$orderID);
		$totalAmont = (float)($cart->getQuote()->getGrandTotal()*100);
		$currency = $objectManager->get('Magento\Store\Model\StoreManagerInterface')->getStore()->getCurrentCurrencyCode();
		$access_id = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('payment/classyllama_llamacoin/access_id');
		$merchantAccessNo = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('payment/classyllama_llamacoin/merchantAccessNo');
		$storeNo = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('payment/classyllama_llamacoin/storeNo');
		$app_private_key = $objectManager->get('Magento\Framework\App\Config\ScopeConfigInterface')->getValue('payment/classyllama_llamacoin/app_private_key');
		$subject = str_replace('"' , '', $objectManager->get('\Magento\Store\Model\StoreManagerInterface')->getStore()->getName());

		$config = array (
			//id assigned by por Starpay
			'access_id' => $access_id,
			//transaction type(see documentation)
			'type' => "2003",
			//default version is 1.0
			'version' => "1.0",
			//timestamp format yyyy-MM-dd HH:mm:ss
			'timestamp' => $timestamp,
			//see documentation for how to set up the content field
			'content' => "{merchantAccessNo:\"$merchantAccessNo\", orderNo: \"$orderID\", orderAmt: $totalAmont, subject: \"$subject\", currency: \"$currency\", bgRetUrl: \"$bgRetUrl\", storeNo: \"$storeNo\"}",
			//for now we are 100% exclusive with JSON.
			'format'=>"JSON",
			//See "message signature" in the documentation
			'sign' => ""
		);

		$clsName="StarpayUtil";
		$ret = $clsName::SignData($config, $app_private_key);
		$config["sign"]=$ret;

		$result = $clsName::curl($gatewayurl,$config);

		// echo $result;

		$array_result = json_decode($result, true);
		if ($array_result['code'] != 'R000') {
			$png = 'error';
		}
		else{
			$content_result = json_decode($array_result['content'], true);
			$url = $content_result['coreUrl'];
			$png = $this->createTempQrcode($url);
		}

		echo $png."&".$quote_id;
	}

	public function createTempQrcode($data)
    {
        require_once 'lib/phpqrcode.php';
        $object = new \QRcode();
        $errorCorrectionLevel = 'L';    // Error logging level
        $matrixPointSize = 5;			//generate image size
        ob_start();
        $returnData = $object->png($data,false,$errorCorrectionLevel, $matrixPointSize, 2);
        $imageString = base64_encode(ob_get_contents());
        ob_end_clean();
        return "data:image/png;base64,".$imageString;
    }

	// Random generate
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
