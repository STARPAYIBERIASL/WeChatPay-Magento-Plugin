<?php

namespace ClassyLlama\LlamaCoin\Controller\Qrcode;

class Movil extends \Magento\Framework\App\Action\Action
{
    public function __construct(\Magento\Framework\App\Action\Context $context)
    {
        // $this->helperData = $helperData;
        parent::__construct($context);
    }

    public function execute()
    {
        require_once 'lib/StarpayUtil.php';

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$cart = $objectManager->get('\Magento\Checkout\Model\Cart');

		$quote_id = $cart->getQuote()->getId();
		$base_url = $objectManager->get('\Magento\Store\Model\StoreManagerInterface')->getStore()->getBaseUrl();

        $timestamp = date('Y-m-d H:i:s');
        // $timestamp = date('2019-07-15 18:28:05');
		$bgRetUrl = $base_url."llamacoin/qrcode/notify";
		$orderID = $this->generateRandomString()."&".$quote_id;
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
			'type' => "2001",
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
        $config["quote_id"]=$quote_id;

        echo json_encode($config, true);
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
