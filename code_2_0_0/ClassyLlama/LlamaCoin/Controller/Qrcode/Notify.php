<?php

namespace ClassyLlama\LlamaCoin\Controller\Qrcode;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\Request\InvalidRequestException;


class Notify extends \Magento\Framework\App\Action\Action implements CsrfAwareActionInterface
{
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
        // $this->helperData = $helperData;
        $this->logger = $logger;
        $this->logger_custom = $logger_custom;
        parent::__construct($context);
    }

    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }

    public function execute()
    {

        // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

        // $checkoutSession = $objectManager->get('Magento\Checkout\Model\Session');
        // $quote_create = $objectManager->get('\Magento\Quote\Api\CartRepositoryInterface');
        // $quote = $quote_create->getActive($checkoutSession->getQuoteId());
        // $quote->setPaymentMethod('classyllama_llamacoin');
        // $quote->getPayment()->importData(['method' => 'classyllama_llamacoin']);
        // $order = $objectManager->get('Magento\Quote\Api\CartManagementInterface')->placeOrder($checkoutSession->getQuoteId());

        $this->logger->alert('Mensaje Alerta');
        $this->logger->critical('Mensaje Crítico');
        $this->logger->debug('Mensaje Debug');
        $this->logger->emergency('Mensaje Emergencia');
        $this->logger->error('Mensaje Error');
        $this->logger->info('Mensaje Info');
        $this->logger->notice('Mensaje Notice');
        $this->logger->warning('Mensaje Warning');

        $this->logger->log(\Psr\Log\LogLevel::INFO, 'Mensaje Log');

        $this->logger_custom->info('Entrando por Notify.php');

        // PLACE ORDER
        // $result = $_POST;

        // $quote_id = $result['id'];
        // $checkoutSession = $objectManager->get('Magento\Checkout\Model\Session');

        // $this->logger_custom->info('Empezando Submit');
        // $quote_create = $objectManager->get('\Magento\Quote\Model\QuoteFactory')->create();
        // $this->logger_custom->info('Creado Quote');
        // $quote = $quote_create->load($quote_id);
        // $this->logger_custom->info('Cargada Quote');
        // $quote->setPaymentMethod('classyllama_llamacoin');
        // $quote->getPayment()->importData(['method' => 'classyllama_llamacoin']);
        // $this->logger_custom->info('Modificado Metodo de Pago Quote');
        // $quote->save();
        // $this->logger_custom->info('Salvada Quote');
        // $order = $objectManager->get('\Magento\Quote\Model\QuoteManagement')->placeOrder($quote_id);
        // $this->logger_custom->info('Orden Creada');

        // $order->setEmailSent(0);
        // $increment_id = $order->getRealOrderId();

        try{
            $this->logger_custom->info('Try');
            $access = "";
            if (!empty($_POST)) {
                $this->logger_custom->info('POST');
                $access = 'POST';
            } else if (!empty($_GET)) {
                $this->logger_custom->info('GET');
                $access = 'GET';
            }

            if ($access === 'POST' || $access === 'GET') {
                if ($access === 'POST'){
                    $this->logger_custom->info('Entrando POST');
                    $result = $_POST;
            		$content = json_decode($result['content'], true);

                    $this->logger_custom->info('content: '.$result['content']);

                    // GET PARAMETERS
                    $access_id = $result['access_id'];
                    $merchantAccessNo = $content['merchantAccessNo'];
                    $orderNo = $content['orderNo'];
                    $merOrderNo = $content['merOrderNo'];
                    $orderCurrency = $content['orderCurrency'];
                    $orderAmt = (int) $content['orderAmt'];
                    $payCurrency = $content['payCurrency'];
                    $payAmt = $content['payAmt'];
                    $acctDate = $content['acctDate'];
                    $status = $content['tradeStatus'];

                    $this->logger_custom->info('access_id: '.$access_id);
                    $this->logger_custom->info('merchantAccessNo: '.$merchantAccessNo);
                    $this->logger_custom->info('orderNo: '.$orderNo);
                    $this->logger_custom->info('merOrderNo: '.$merOrderNo);
                    $this->logger_custom->info('orderCurrency: '.$orderCurrency);
                    $this->logger_custom->info('orderAmt: '.$orderAmt);
                    $this->logger_custom->info('payCurrency: '.$payCurrency);
                    $this->logger_custom->info('$payAmt: '.$payAmt);
                    $this->logger_custom->info('acctDate: '.$acctDate);
                    $this->logger_custom->info('tradeStatus: '.$status);


                    if ($status == 'R000'){
                        $cart = mb_split("&", $merOrderNo);
                        $quote_id = $cart[1];

                        $this->logger_custom->info('quote_id: '.$quote_id);

                        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

                        // PLACE ORDER
                        // $checkoutSession = $objectManager->get('Magento\Checkout\Model\Session');
                        // $this->logger_custom->info('Quote create next');
                        // $quote_create = $objectManager->get('\Magento\Quote\Api\CartRepositoryInterface');
                        // $this->logger_custom->info('Quote active next with id: '.$quote_id);
                        // $quote = $quote_create->getActive($quote_id);
                        // $this->logger_custom->info('Quote modified payment method next');
                        // $quote->setPaymentMethod('classyllama_llamacoin');
                        // $quote->getPayment()->importData(['method' => 'classyllama_llamacoin']);
                        // // $order = $objectManager->get('Magento\Quote\Api\CartManagementInterface')->placeOrder($checkoutSession->getQuoteId());
                        // $this->logger_custom->info('Place order next: '.$quote_id);
                        // $order = $objectManager->get('Magento\Quote\Api\CartManagementInterface')->placeOrder((int) $quote_id);
                        // $this->logger_custom->info('Order place taked');

                        // SUBMIT
                        // $this->logger_custom->info('Empezando Submit');
                        // $quote_create = $objectManager->get('\Magento\Quote\Model\QuoteFactory')->create();
                        // $this->logger_custom->info('Creado Quote');
                        // $quote = $quote_create->load($quote_id);
                        // $this->logger_custom->info('Cargada Quote');
                        // $quote->setPaymentMethod('classyllama_llamacoin');
                        // $quote->getPayment()->importData(['method' => 'classyllama_llamacoin']);
                        // $this->logger_custom->info('Modificado Metodo de Pago Quote');
                        // $quote->save();
                        // $this->logger_custom->info('Salvada Quote');
                        // $order = $objectManager->get('\Magento\Quote\Model\QuoteManagement')->submit($quote);
                        // $this->logger_custom->info('Orden Creada');

                        // $order->setEmailSent(0);
                        // $increment_id = $order->getRealOrderId();
                        // if($order->getEntityId()){
                        //     $result['order_id']= $order->getRealOrderId();
                        // }else{
                        //     $result=['error'=>1,'msg'=>'Your custom message'];
                        // }

                        $this->logger_custom->info('Empezando Submit');
                        $quote_create = $objectManager->get('\Magento\Quote\Model\QuoteFactory')->create();
                        $this->logger_custom->info('Creado Quote');
                        $quote = $quote_create->load($quote_id);
                        $this->logger_custom->info('Cargada Quote');
                        $quote->setPaymentMethod('classyllama_llamacoin');
                        $quote->getPayment()->importData(['method' => 'classyllama_llamacoin']);
                        $this->logger_custom->info('Modificado Metodo de Pago Quote');
                        $quote->save();
                        $this->logger_custom->info('Salvada Quote');
                        // $order = $objectManager->get('\Magento\Quote\Model\QuoteManagement')->placeOrder($quote_id);
                        $order = $objectManager->get('\Magento\Quote\Model\QuoteManagement')->submit($quote);
                        $this->logger_custom->info('Orden Creada');
                    }
                    $this->logger_custom->info('Echo true');
                    echo 'SUCCESS';
                }
                else{
                    $this->logger_custom->info('Entrando GET');
                    $result = $_GET;
            		$content = json_decode($result['content'], true);

                    // GET PARAMETERS
                    $access_id = $result['access_id'];
                    $merchantAccessNo = $content['merchantAccessNo'];
                    $orderNo = $content['orderNo'];
                    $merOrderNo = $content['merOrderNo'];
                    $orderCurrency = $content['orderCurrency'];
                    $orderAmt = (int) $content['orderAmt'];
                    $payCurrency = $content['payCurrency'];
                    $payAmt = $content['payAmt'];
                    $acctDate = $content['acctDate'];
                    $status = $content['tradeStatus'];

                    $this->logger_custom->info('access_id: '.$access_id);
                    $this->logger_custom->info('merchantAccessNo: '.$merchantAccessNo);
                    $this->logger_custom->info('orderNo: '.$orderNo);
                    $this->logger_custom->info('merOrderNo: '.$merOrderNo);
                    $this->logger_custom->info('orderCurrency: '.$orderCurrency);
                    $this->logger_custom->info('orderAmt: '.$orderAmt);
                    $this->logger_custom->info('payCurrency: '.$payCurrency);
                    $this->logger_custom->info('$payAmt: '.$payAmt);
                    $this->logger_custom->info('acctDate: '.$acctDate);
                    $this->logger_custom->info('tradeStatus: '.$status);

                    if ($status == 'R000'){
                        $cart = mb_split("&", $merOrderNo);
                        $quote_id = $cart[1];

                        $this->logger_custom->info('quote_id: '.$quote_id);

                        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

                        // PLACE ORDER
                        // $checkoutSession = $objectManager->get('Magento\Checkout\Model\Session');
                        // $quote_create = $objectManager->get('\Magento\Quote\Api\CartRepositoryInterface');
                        // $quote = $quote_create->getActive($quote_id);
                        // $quote->setPaymentMethod('classyllama_llamacoin');
                        // $quote->getPayment()->importData(['method' => 'classyllama_llamacoin']);
                        // $order = $objectManager->get('Magento\Quote\Api\CartManagementInterface')->placeOrder($checkoutSession->getQuoteId());

                        // SUBMIT
                        $this->logger_custom->info('Empezando Submit');
                        $quote_create = $objectManager->get('\Magento\Quote\Model\QuoteFactory')->create();
                        $this->logger_custom->info('Creado Quote');
                        $quote = $quote_create->load($quote_id);
                        $this->logger_custom->info('Cargada Quote');
                        $quote->setPaymentMethod('classyllama_llamacoin');
                        $quote->getPayment()->importData(['method' => 'classyllama_llamacoin']);
                        $this->logger_custom->info('Modificado Metodo de Pago Quote');
                        $quote->save();
                        $this->logger_custom->info('Salvada Quote');
                        $order = $objectManager->get('\Magento\Quote\Model\QuoteManagement')->submit($quote);
                        $this->logger_custom->info('Orden Creada');

                        // $order->setEmailSent(0);
                        // $increment_id = $order->getRealOrderId();
                        // if($order->getEntityId()){
                        //     $result['order_id']= $order->getRealOrderId();
                        // }else{
                        //     $result=['error'=>1,'msg'=>'Your custom message'];
                        // }
                    }
                    echo 'SUCCESS';
                }
            }

        }
        catch (Exception $e){
        	$idLogExc = generateIdLog();
        	escribirLog($idLogExc." -- Excepcion en la validacion: ".$e->getMessage(),"si");
        	die("Excepcion en la validacion");
        }
    }
}
